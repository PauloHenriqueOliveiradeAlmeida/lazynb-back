<?php

namespace Raven\Core\RouteHandler\Dtos;

class HttpMethodDto
{
	public readonly string $httpMethodName;
	public readonly string $controllerMethod;
	public readonly string $endpoint;

	public function __construct(string $httpMethodName, string $controllerMethod, string $endpoint)
	{
		$this->httpMethodName = $httpMethodName;
		$this->controllerMethod = $controllerMethod;
		$this->endpoint = $endpoint;
	}
}
