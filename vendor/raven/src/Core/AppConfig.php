<?php

namespace Raven\Core;

class AppConfig
{

	public array $controllers;
	public ?array $methodsAllowed;

	public function __construct(array $controllers, ?array $methodsAllowed = null)
	{
		$this->controllers = $controllers;
		$this->methodsAllowed = $methodsAllowed ?? ["POST", "GET", "PUT", "PATCH", "DELETE", "HEAD", "OPTIONS"];
	}
}
