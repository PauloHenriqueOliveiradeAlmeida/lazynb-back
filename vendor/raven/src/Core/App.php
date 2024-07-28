<?php


namespace Raven\Core;

use Raven\Core\Exceptions\ExceptionHandler;
use Raven\Core\Route\RouteHandler;

set_exception_handler(ExceptionHandler::throwException(...));

class App
{


	public function __construct(AppConfig $appConfig)
	{
		$routeHandler = new RouteHandler($appConfig);
		$routeHandler->manageRoute();
	}

	public static function bootstrap(AppConfig $appConfig)
	{
		return new static($appConfig);
	}
}
