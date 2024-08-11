<?php

namespace Raven\Core\Route;

use Raven\Core\AppConfig;
use Raven\Core\Route\Dtos\ControllerDto;
use Raven\Core\Route\Dtos\HttpMethodDto;
use Raven\Falcon\Attributes\Controller;
use Raven\Falcon\Attributes\HttpMethods\IHttpMethod;
use Raven\Falcon\Http\Exceptions\MethodNotAllowedException;
use Raven\Falcon\Http\Exceptions\NotFoundException;
use ReflectionAttribute;
use ReflectionClass;

final class RouteHandler
{
	/**
	 * @var ControllerDto[]
	 */
	private array $controllers = [];

	public function __construct(private readonly AppConfig $appConfig)
	{
	}

	public function serveStaticFiles(string $folder, string $endpoint)
	{
		$requestedUrl = $this->sanitizeUrl($_SERVER["REQUEST_URI"]);
		$requestedMethod = $_SERVER["REQUEST_METHOD"];

		if (
			$requestedMethod !== "GET" ||
			!in_array("GET", $this->appConfig->methodsAllowed)
		) {
			return;
		}

		$staticFiles = scandir($folder);

		if (!$staticFiles) {
			throw new \Error("Invalid Folder");
		}

		foreach ($staticFiles as $entry) {
			if (is_dir($entry)) {
				continue;
			}
			$endpointBuilder = EndpointBuilder::set($entry, $requestedUrl)
				->withBase($endpoint)
				->get();

			if ($endpointBuilder->endpoint !== $requestedUrl) {
				continue;
			}

			header("Content-Type: " . mime_content_type("$folder/$entry"));
			readfile("$folder/$entry");
			exit();
		}
	}

	public function manageRoute()
	{
		foreach ($this->appConfig->controllers as $route) {
			array_push($this->controllers, $this->extractRouteData($route));
		}

		$requestedUrl = $this->sanitizeUrl($_SERVER["REQUEST_URI"]);
		$requestedMethod = $_SERVER["REQUEST_METHOD"];

		foreach ($this->controllers as $controllerData) {
			foreach ($controllerData->methods as $method) {
				$endpoint = EndpointBuilder::set($method->endpoint, $requestedUrl)
					->withBase($controllerData->endpoint)
					->withBase($this->appConfig->basePath)
					->withParameters()
					->get();

				if ($endpoint->endpoint === $requestedUrl) {
					if (
						!in_array($method->httpMethodName, $this->appConfig->methodsAllowed)
					) {
						throw new MethodNotAllowedException();
					}

					if ($method->httpMethodName === $requestedMethod) {
						$controllerInstance = new $controllerData->controller();

						if (!isset($endpoint->parameters)) {
							$controllerInstance->{$method->controllerMethod}();
						}

						$controllerMethod = new \ReflectionMethod(
							$controllerInstance,
							$method->controllerMethod
						);
						$controllerMethodRequestedParameters = array_map(
							fn(\ReflectionParameter $param) => $param->getName(),
							$controllerMethod->getParameters()
						);
						$parameters = array_filter(
							$endpoint->parameters,
							fn(string $paramName) => in_array(
								$paramName,
								$controllerMethodRequestedParameters
							),
							ARRAY_FILTER_USE_KEY
						);

						$controllerInstance->{$method->controllerMethod}(...$parameters);
					}
				}
			}
		}
		throw new NotFoundException();
	}

	private function extractRouteData(string $route)
	{
		$reflectedRoute = new ReflectionClass("\\$route");
		$routeEndpoint = $reflectedRoute->getAttributes(Controller::class);
		if (count($routeEndpoint) === 0) {
			throw new \Error("nao é uma rota válida");
		}
		$routeEndpoint = $routeEndpoint[0]->getArguments()["endpoint"];

		$httpMethods = [];

		foreach ($reflectedRoute->getMethods() as $routeMethod) {
			$httpMethodAttributes = $routeMethod->getAttributes(
				IHttpMethod::class,
				ReflectionAttribute::IS_INSTANCEOF
			);
			if (count($httpMethodAttributes) === 0) {
				return;
			}

			$routeHttpMethod = $httpMethodAttributes[0];
			$httpMethodName = strtoupper(
				substr(
					$routeHttpMethod->getName(),
					strrpos($routeHttpMethod->getName(), "\\") + 1
				)
			);
			$httpMethodDto = new HttpMethodDto(
				$httpMethodName,
				$routeMethod->getName(),
				$routeHttpMethod->getArguments()["endpoint"] ?? ""
			);

			array_push($httpMethods, $httpMethodDto);
		}
		$controllerDto = new ControllerDto(
			$routeEndpoint,
			$reflectedRoute->getName(),
			$httpMethods
		);
		return $controllerDto;
	}

	/**
	 * Method to sanitize url
	 * @param string $url is a url to sanitize
	 */
	private static function sanitizeUrl(string $url)
	{
		$sanitized = substr($url, strpos($url, "/"));
		$sanitized =
			$sanitized[strlen($sanitized) - 1] === "/"
				? substr($sanitized, 0, strlen($sanitized) - 1)
				: $sanitized;

		return $sanitized;
	}
}
