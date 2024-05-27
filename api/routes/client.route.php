<?php

require_once __DIR__ . "/../packages/route/route.php";
require_once __DIR__ . "/../controllers/client/client.controller.php";

Route::endpoint('/clients', ClientController::class)->methods(function (Route $route) {
	$route->post('create', params: $_POST);
	$route->put(endpoint: ':id', callback: 'update', params: $_POST);
	$route->get('getAll');
	$route->get(endpoint: ':id', callback: 'getById');
	$route->delete('delete');
});
