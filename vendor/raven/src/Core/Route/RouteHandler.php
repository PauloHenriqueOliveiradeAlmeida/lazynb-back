<?php

namespace Raven\Core\Route;

use Raven\Core\AppConfig;
use Raven\Core\RouteHandler\Dtos\ControllerDto;
use Raven\Core\RouteHandler\Dtos\HttpMethodDto;
use Raven\Falcon\Attributes\Controller;
use Raven\Falcon\Attributes\HttpMethods\IHttpMethod;
use Raven\Falcon\Http\Exceptions\MethodNotAllowedException;
use Raven\Falcon\Http\Exceptions\NotFoundException;
use ReflectionAttribute;
use ReflectionClass;

final class RouteHandler
{
	private readonly AppConfig $appConfig;

	/**
	 * @var ControllerDto[]
	 */
	private array $controllers = [];

	public function __construct(AppConfig $appConfig)
	{
		$this->appConfig = $appConfig;
	}

	public function manageRoute()
	{
		foreach ($this->appConfig->controllers as $route) array_push($this->controllers, $this->extractRouteData($route));

		$requestedUrl = $this->sanitizeUrl($_SERVER['REQUEST_URI']);
		$requestedMethod = $_SERVER['REQUEST_METHOD'];

		foreach ($this->controllers as $controllerData) {
			foreach ($controllerData->methods as $method) {
				$endpoint = EndpointBuilder::set($method->endpoint, $requestedUrl)
					->withBase($controllerData->endpoint)
					->withParameters()
					->get();
				if ($endpoint->endpoint === $requestedUrl) {
					if (!in_array($method->httpMethodName, $this->appConfig->methodsAllowed))
						throw new MethodNotAllowedException();

					if ($method->httpMethodName === $requestedMethod) {
						$controllerInstance = new $controllerData->controller;

						if (!isset($endpoint->parameters)) $controllerInstance->{$method->controllerMethod}();

						$controllerMethod = new \ReflectionMethod($controllerInstance, $method->controllerMethod);
						$controllerMethodRequestedParameters = array_map(fn (\ReflectionParameter $param) => $param->getName(), $controllerMethod->getParameters());
						$parameters = array_filter($endpoint->parameters, fn (string $paramName) => in_array($paramName, $controllerMethodRequestedParameters), ARRAY_FILTER_USE_KEY);

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
		if (count($routeEndpoint) === 0) throw new \Error('nao é uma rota válida');
		$routeEndpoint = $routeEndpoint[0]->getArguments()["endpoint"];

		$httpMethods = [];

		foreach ($reflectedRoute->getMethods() as $routeMethod) {
			$httpMethodAttributes = $routeMethod->getAttributes(IHttpMethod::class, ReflectionAttribute::IS_INSTANCEOF);
			if (count($httpMethodAttributes) === 0) return;

			$routeHttpMethod = $httpMethodAttributes[0];
			$httpMethodName = strtoupper(substr($routeHttpMethod->getName(), strrpos($routeHttpMethod->getName(), "\\") + 1));
			$httpMethodDto = new HttpMethodDto($httpMethodName, $routeMethod->getName(), $routeHttpMethod->getArguments()["endpoint"] ?? "");

			array_push($httpMethods, $httpMethodDto);
		}
		$controllerDto = new ControllerDto($routeEndpoint, $reflectedRoute->getName(), $httpMethods);
		return $controllerDto;
	}

	/**
	 * Method to sanitize url
	 * @param string $url is a url to sanitize
	 */
	private static function sanitizeUrl(string $url)
	{
		$sanitized = substr($url, (strpos($url, '/')));
		$sanitized = $sanitized[strlen($sanitized) - 1] === '/' ? $sanitized : $sanitized . '/';

		return $sanitized;
	}
}
