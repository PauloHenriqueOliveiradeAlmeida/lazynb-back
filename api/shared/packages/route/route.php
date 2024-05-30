<?php

class Route
{
	private readonly mixed $controller;
	private readonly string $endpoint;
	private readonly string $request_uri;
	private readonly string $request_method;

	public function __construct(string $endpoint, $controller)
	{
		$this->controller = $controller;
		$this->request_uri = $_SERVER['REQUEST_URI'];
		$this->request_method = $_SERVER['REQUEST_METHOD'];
		$this->endpoint = $endpoint;
	}

	public static function endpoint(string $endpoint, $controller) {
		return new static($endpoint, $controller);
	}

	public function methods(callable $callback) {
		$callback($this);
	}

	public function post($callback, ?array $params = [], ?string $endpoint = '') {
		$formmated_endpoint = "{$this->endpoint}/{$endpoint}";
		if ($this->request_method === "POST") {
			if ($this->sanitizeUrl($this->request_uri) === $formmated_endpoint) {
				return $this->controller::{$callback}($params);
			}
		}

	}

	public function put($callback, ?array $params = [], ?string $endpoint = '') {
		$param = null;
		$formmated_endpoint = "{$this->endpoint}/{$endpoint}";

		if (substr($endpoint, 0, 1) === ":") {
			$param_name = substr($endpoint, 1);

			if (isset($_GET[$param_name])) {
				$param = $_GET[$param_name];
				$params = [$param, $params];
				$formmated_endpoint = "{$this->endpoint}?" . substr($endpoint, 1) . "=$param/";
			}
		}

		if ($this->request_method === "PUT") {
			if ($this->sanitizeUrl($this->request_uri) === $formmated_endpoint) {
				return $this->controller::{$callback}(...$params);
			}
		}

	}

	public function patch($callback, ?array $params = [], ?string $endpoint = '') {
		$param = null;
		$formmated_endpoint = "{$this->endpoint}/{$endpoint}";

		if (substr($endpoint, 0, 1) === ":") {
			$param_name = substr($endpoint, 1);

			if (isset($_GET[$param_name])) {
				$param = $_GET[$param_name];
				$params = [$param, $params];
				$formmated_endpoint = "{$this->endpoint}?" . substr($endpoint, 1) . "=$param/";
			}
		}

		if ($this->request_method === "PATCH") {
			if ($this->sanitizeUrl($this->request_uri) === $formmated_endpoint) {
				return $this->controller::{$callback}(...$params);
			}
		}

	}

	public function get($callback, ?string $endpoint = '')
	{
		$param = null;
		$formmated_endpoint = "{$this->endpoint}/{$endpoint}";

		if (substr($endpoint, 0, 1) === ":") {
			$param_name = substr($endpoint, 1);

			if (isset($_GET[$param_name])) {
				$param = $_GET[$param_name];
				$formmated_endpoint = "{$this->endpoint}?" . substr($endpoint, 1) . "=$param/";
			}
		}

		if ($this->request_method === "GET") {
			if ($this->sanitizeUrl($this->request_uri) === $formmated_endpoint) {
				return $this->controller::{$callback}($param);
			}
		}


	}

	public function delete($callback, ?string $endpoint = '')
	{
		$param = null;
		$formmated_endpoint = "{$this->endpoint}/{$endpoint}";

		if (substr($endpoint, 0, 1) === ":") {
			$param_name = substr($endpoint, 1);

			if (isset($_GET[$param_name])) {
				$param = $_GET[$param_name];
				$formmated_endpoint = "{$this->endpoint}?" . substr($endpoint, 1) . "=$param/";
			}
		}

		if ($this->request_method === "DELETE") {
			if ($this->sanitizeUrl($this->request_uri) === $formmated_endpoint) {
				return $this->controller::{$callback}($param);
			}
		}
	}

	private function sanitizeUrl($url) {
		return substr($url, strrpos($url, '/')) . "/";
	}
}
