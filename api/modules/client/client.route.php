<?php
require_once __DIR__ . "/../../shared/packages/request/request.php";
require_once __DIR__ . "/../../shared/packages/route/route.php";
require_once "client.controller.php";

Route::endpoint('/clients', ClientController::class)->methods(function (Route $route) {
	$route->post('create', params: Request::body());
	$route->put(endpoint: ':id', callback: 'update', params: Request::body());
	$route->get('getAll');
	$route->get(endpoint: ':id', callback: 'getById');
	$route->delete(endpoint: ':id', callback: 'delete');
});
