<?php

namespace Raven\App;

class AppConfig
{

	/**
	 * @string[]
	 */
	public array $routes;

	public function __construct(array $routes)
	{
		$this->routes = $routes;
	}
}
