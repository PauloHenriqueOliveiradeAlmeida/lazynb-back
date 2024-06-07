<?php

class HttpResponse {
	public const CREATED = 201;
	public const OK = 200;
	public const NO_CONTENT = 204;
	public const BAD_REQUEST = 400;
	public const UNAUTHORIZED = 401;
	public const NOT_FOUND = 404;
	public const CONFLICT = 409;
	public const SERVER_ERROR = 500;

	public static function send(?int $http_status_code = self::OK) {
		http_response_code($http_status_code);
		die();
	}

	public static function sendBody(array $body, ?int $http_status_code = self::OK) {
		echo json_encode($body);
		http_response_code($http_status_code);
		die();
	}
}
