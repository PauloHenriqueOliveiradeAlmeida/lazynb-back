<?php

require_once __DIR__ . "/../packages/route/route.php";
require_once __DIR__ . "/../controllers/property/property.controller.php";

Route::endpoint('/properties', PropertyController::class)->methods(function (Route $route) {
	$route->post(endpoint: ':id', callback: 'create', params: $_POST);
	$route->put(endpoint: ':id', callback: 'update', params: $_POST);
	$route->get('getAll');
	$route->get(endpoint: ':id', callback: 'getById');
	$route->delete('delete');
});
