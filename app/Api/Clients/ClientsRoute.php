<?php

namespace App\Api\Clients;
use App\Api\Users\ClientsController;
use Raven\Route;

Route::endpoint('/api/clients', ClientsController::class)->methods(function (Route $route) {
	$route->post(callback: "create");
	$route->get(callback: "getAll");
	$route->get(endpoint: ':id', callback: "getOne");
	$route->put(endpoint: ':id', callback: "update");
	$route->delete(endpoint: ':id', callback: "delete");
});
