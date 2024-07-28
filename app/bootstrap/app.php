<?php

namespace App;

require "vendor/autoload.php";

use App\Api\Posts\PostsController;
use App\Api\Clients\ClientsController;
use App\Api\Users\UserController;
use Raven\Core\App;
use Raven\Core\AppConfig;

$appConfig = new AppConfig(
	controllers: [
		UserController::class,
		ClientsController::class,
		PostsController::class,
	]
);

App::bootstrap($appConfig);
