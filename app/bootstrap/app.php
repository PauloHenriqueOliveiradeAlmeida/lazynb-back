<?php

namespace App;

use Raven\App\App;
use Raven\App\AppConfig;

require 'vendor/autoload.php';

$appConfig = new AppConfig(routes: [
	__DIR__ . "/../Api/Users/UserRoute.php",
	__DIR__ . "/../Api/Clients/ClientsRoute.php"
]);


App::bootstrap($appConfig);
