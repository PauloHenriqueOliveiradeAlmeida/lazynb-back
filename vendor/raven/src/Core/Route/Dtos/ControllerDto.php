<?php

namespace Raven\Core\RouteHandler\Dtos;

class ControllerDto
{
	public readonly string $endpoint;
	public readonly string $controller;

	/**
	 * @var HttpMethodDto[]
	 */
	public readonly array $methods;

	/**
	 * @param HttpMethodDto[] $methods
	 */
	public function __construct(string $endpoint, string $controller, array $methods)
	{
		$this->endpoint = $endpoint;
		$this->controller = $controller;
		$this->methods = $methods;
	}
}
