<?php

namespace App;

require "vendor/autoload.php";

use App\Api\Users\UserController;
use Raven\Core\App;
use Raven\Core\AppConfig;

$appConfig = new AppConfig(controllers: [UserController::class]);

App::bootstrap($appConfig);
