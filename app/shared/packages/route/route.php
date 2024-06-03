<?php


class Route
{
	private readonly mixed $controller;
	private readonly string $endpoint;
	private readonly string $request_uri;
	private readonly string $request_method;

	private array $route_results = [];

	private bool $is_authenticated = true;
	private const METHODS = [
		"GET",
		"POST",
		"PUT",
		"PATCH",
		"DELETE"
	];

	public function __construct(string $endpoint, ?string $controller = '')
	{
		$this->controller = $controller;
		$this->request_uri = $_SERVER['REQUEST_URI'];
		$this->request_method = $_SERVER['REQUEST_METHOD'];
		$this->endpoint = $endpoint;
	}

	public static function endpoint(string $endpoint, ?string $controller = '')
	{
		return new static($endpoint, $controller);
	}

	public function withAuth($auth, ?string $method = 'check')
	{
		$this->is_authenticated = $auth::{$method}();
		return $this;
	}

	public function methods(callable $callback)
	{
		$callback($this);

		$success_method = array_filter($this->route_results, function ($result) {
			if ($result["message"] === "success") {
				return $result;
			}
		});
		if (count($success_method) === 1) {
			return reset($success_method)["method"]();
		}

	}

	public function __call(string $name, $arguments)
	{
		$endpoint = $arguments["endpoint"] ?? "";
		$params = [$arguments["params"] ?? []];

		if ($this->request_method === strtoupper($name) && in_array($this->request_method, self::METHODS)) {
			$formmated_endpoint = $this->endpoint ? "{$this->endpoint}/" : "";
			$formmated_endpoint .= $endpoint ? "{$endpoint}/" : "";

			if (substr($endpoint, 0, 1) === ":") {
				$param_name = substr($endpoint, 1);

				if (isset($_GET[$param_name])) {
					$param = $_GET[$param_name];
					$params = [$param, ...$params];
					$formmated_endpoint = "{$this->endpoint}?" . substr($endpoint, 1) . "=$param/";
				}
			}

			if ($this->sanitizeUrl($this->request_uri, "/api") === $formmated_endpoint) {

				if ($this->is_authenticated) {
					$this->route_results[] = [
						"message" => "success",
						"method" => function () use($arguments, $params)  {$this->controller::{$arguments["callback"]}(...$params);}
					];
				} else {
					HttpResponse::sendBody([
						"message" => "Você não está autenticado no sistema, faça login antes de prosseguir",
						"status" => HttpResponse::UNAUTHORIZED
					], HttpResponse::UNAUTHORIZED);
				}
			}
		}
	}

	private function sanitizeUrl($url, string $base)
	{
		return substr($url, (strpos($url, $base) + strlen($base))) . "/";
	}
}
