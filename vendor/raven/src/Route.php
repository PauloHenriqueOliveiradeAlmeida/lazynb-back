<?php

namespace Raven;

use Closure;
use Raven\Contracts\Route\RouteHttpMethodArgumentsContract;
use Raven\Http\Exceptions\NotFoundException;
use Raven\Http\StatusCode;
use ReflectionMethod;
use ReflectionParameter;

enum RequestMethod: string
{
	case POST = "POST";
	case GET = "GET";
	case PUT = "PUT";
	case PATCH = "PATCH";
	case DELETE = "DELETE";
};

class Route
{

	/**
	 * the "controller" variable is responsible for storing the controller informed for the route
	 */
	private readonly string $controller;


	/**
	 * the "endpoint" variable is responsible for storing the route endpoint
	 */
	private readonly string $endpoint;

	// TODO: não é responsabilidade da Route
	private readonly string $request_uri;

	// TODO: métodos acessíveis não são responsabilidade da Route, mas sim do App Config
	private readonly RequestMethod $request_method;

	/**
	 * Route processing result queue
	 */
	private array $route_results = [];

	// TODO: não é responsabilidade da Route
	private bool $is_authenticated = true;



	/**
	 * @param string $endpoint route access endpoint
	 * @param class-string<Controller> $controller is a controller inherited from the Controller class
	 */
	public function __construct(string $endpoint, string $controller = Controller::class)
	{
		$this->controller = $controller;
		$this->request_uri = $_SERVER['REQUEST_URI'];
		$this->request_method = RequestMethod::from($_SERVER["REQUEST_METHOD"]);
		$this->endpoint = $endpoint;
	}

	/**
	 * method to define the route endpoint and controller
	 * @param string $endpoint route access endpoint
	 * @param class-string<Controller> $controller is a controller inherited from the Controller class
	 */
	public static function endpoint(string $endpoint, string $controller = null)
	{
		return new static($endpoint, $controller);
	}

	// /**
	//  * middleware method to execute Guard Method
	//  * @param class-string $auth is a Auth class
	//  * @param ?string $method is a default method to check credentials and authenticate
	//  */
	// public function withGuard(string $auth, ?string $method = 'check')
	// {
	// 	$this->is_authenticated = $auth::{$method}();
	// 	return $this;
	// }

	/**
	 * Method to group routes in same base endpoint and controller
	 * @param Closure(Route): void $callback is a function to group route methods
	 */
	public function methods(Closure $callback)
	{
		$callback($this);

		$successMethod = array_filter($this->route_results, fn ($result) => $result["message"] === "success");
		if (count($successMethod) === 1) {
			$controller = reset($successMethod)["method"];
			$controller();
		}
		throw new NotFoundException($this->route_results[0]["message"]);
	}


	/**
	 * Is a allowed HTTP request methods
	 * @param "get"|"post"|"put"|"patch"|"delete"|string $name is a method name
	 * @param RouteHttpMethodArgumentsContract $arguments is a HTTP request method parameters
	 */
	public function __call(string $name, $arguments)
	{
		$controllerEndpoint = $arguments["endpoint"] ?? "";
		$params = [];
		if ($arguments["params"]) array_push($params, $arguments["params"]);

		if ($this->request_method === RequestMethod::from(strtoupper($name))) {
			$endpoint = $this->makeEndpoint($controllerEndpoint);
			$urlAndParameters = $this->extractParametersFromUrl($endpoint, $this->request_uri);
			$endpoint = $urlAndParameters ? $urlAndParameters["url"] : $endpoint;

			$params = $urlAndParameters ? [
				...$params,
				...$urlAndParameters["parameters"]
			] : $params;

			$controllerMethod = new ReflectionMethod($this->controller, $arguments["callback"]);
			$controllerMethodRequestedParameters = array_map(fn (ReflectionParameter $param) => $param->getName(), $controllerMethod->getParameters());

			$params = array_filter($params, fn (string $paramName) => in_array($paramName, $controllerMethodRequestedParameters), ARRAY_FILTER_USE_KEY);

			$sanitizedUri = $this->sanitizeUrl($this->request_uri);
			if ($sanitizedUri === $endpoint) {
				$this->route_results[] = [
					"message" => "success",
					"method" => fn () => $this->controller::{$arguments["callback"]}(...$params)
				];
			} else {
				$this->route_results[] = [
					"message" => "Not found",
					"status" => StatusCode::NOT_FOUND
				];
			}
		}
	}

	/**
	 * Method to sanitize url
	 * @param string $url is a url to sanitize
	 */
	private function sanitizeUrl(string $url)
	{
		$sanitized = substr($url, (strpos($url, '/')));
		$sanitized = $sanitized[strlen($sanitized) - 1] === '/' ? $sanitized : $sanitized . '/';

		return $sanitized;
	}

	/**
	 * Method to concatenate root endpoint with controller endpoint
	 */
	private function makeEndpoint(string $controllerEndpoint)
	{
		$endpoint = $this->endpoint ? "{$this->endpoint}/" : "";
		$endpoint .= $controllerEndpoint ? "{$controllerEndpoint}/" : "";

		return $endpoint;
	}

	private function extractParametersFromUrl(string $endpoint, string $url)
	{
		// TODO: percorrer colons e injetar os parametros
		$colons = [];
		$lastColonPosition = 0;
		while (($lastColonPosition = strpos($endpoint, ':', $lastColonPosition))) {
			array_push($colons, $lastColonPosition);
			$lastColonPosition = $lastColonPosition + strlen(':');
		}
		if (!$colons || count($colons) === 0) return false;

		$parameters = [];
		foreach ($colons as $colon) {
			if ($colon > strlen($url)) return false;

			$firstSlashAfterColon = strpos($endpoint, '/', $colon);
			$nameLength = abs($firstSlashAfterColon - $colon);
			$name = substr($endpoint, $colon, $nameLength);
			$name = str_replace('/', '', $name);
			$name = str_replace(':', '', $name);


			$firstSlashAfterColon = strpos($url, '/', $colon);
			$valueLength = abs($firstSlashAfterColon - $colon);
			$value = substr($url, $colon, $valueLength);
			$value = str_replace('/', '', $value);
			$parameters = [...$parameters, $name => $value];
		}

		if (empty($parameters)) return false;

		$urlWithParameters = str_replace(array_keys($parameters), array_values($parameters), $endpoint);
		$urlWithParameters = str_replace(':', '', $urlWithParameters);
		return [
			"parameters" => $parameters,
			"url" => $urlWithParameters
		];
	}
}
