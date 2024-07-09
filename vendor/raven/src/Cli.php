<?php

namespace Raven;

class Cli
{
	private const appDir = __DIR__ . "/../../../app";

	public function start(?int $port = null)
	{
		$host = '127.0.0.1';
		$port = $port ?? 8000;

		$command = "php -S $host:$port " . escapeshellarg(self::appDir . "/bootstrap/app.php") . " short_open_tag=On";

		echo "Starting Raven server...\n";

		passthru("composer dump-autoload");
		passthru($command);
	}

	public function createRouteFile(string $name)
	{
		$originalName = $name;
		$name = strtoupper($name[0]) . substr($name, 1);
		$controllerName = $name . "Controller";

		$routeExample = file_get_contents(__DIR__ . "/Examples/RouteExample.txt");
		$content = str_replace(['{$name}', '{$controllerName}', '{$originalName}'], [$name, $controllerName, $originalName], $routeExample);

		$this->makeDir($name);
		file_put_contents(self::appDir . "/Api/$name/$name" . "Route.php", $content);

		$appFile = file(self::appDir . "/bootstrap/app.php");

		$routeForInsert = '	__DIR__ . "/../Api/' . $name . '/' . $name . 'Route.php"' . "\r\n";

		for ($i = 0; $i < count($appFile); $i++) {
			if ($appFile[$i] === $routeForInsert) {
				echo "File is already inserted on app bootstrap\n";
				break;
			}
			if (preg_match('/__DIR__\s*\.\s*"(.*?)"/', $appFile[$i])) {
				if ($appFile[$i + 1] && !preg_match('/__DIR__\s*\.\s*"(.*?)"/', $appFile[$i + 1])) {
					array_splice($appFile, $i + 1, 0, [$routeForInsert]);
					break;
				}
			}
		}
		file_put_contents(self::appDir . "/bootstrap/app.php", implode($appFile));

		echo "\033[1;32mRoute created sucefully!\033[0m";

		return true;
	}

	private function makeDir(string $dirName)
	{
		return mkdir(self::appDir . "/Api/$dirName");
	}
}
