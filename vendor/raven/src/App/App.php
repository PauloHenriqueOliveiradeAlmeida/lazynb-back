<?php


namespace Raven\App;

use Raven\Http\Response;


set_exception_handler(function (\Throwable $exception) {
	if ($exception instanceof \Exception) {
		return Response::sendBody([
			"message" => $exception->getMessage()
		], $exception->getCode());
	}
	throw $exception;
});

class App
{
	public static function bootstrap(AppConfig $appConfig)
	{
		$routes_results = [];

		foreach ($appConfig->routes as $route) {
			try {
				$result = require $route;
				if ($result instanceof \Exception) $routes_results[] = $exception;
			} catch (\Exception $exception) {
				$routes_results[] = $exception;
			}
		}
		if (!empty($routes_results)) {
			throw $routes_results[0];
		}
	}
}
