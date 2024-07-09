<?php

namespace App\Api\Users;

use App\Api\Users\UserController;
use Raven\Route;


Route::endpoint('/api/users', UserController::class)->methods(function (Route $route) {
	$route->get(callback: 'getAll');
	$route->get(endpoint: ':id/lala/:account', callback: 'getOne');
});
