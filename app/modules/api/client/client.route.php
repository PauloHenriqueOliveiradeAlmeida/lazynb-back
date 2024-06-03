<?php

require_once __DIR__ . "/../../../shared/auth/auth.service.php";
require_once __DIR__ . "/../../../shared/packages/request/request.php";
require_once __DIR__ . "/../../../shared/packages/route/route.php";
require_once "client.controller.php";

Route::endpoint('/clients', ClientController::class)->withAuth(Auth::class)->methods(function (Route $route) {
	$route->post(callback: 'create', params: Request::body());
	$route->put(endpoint: ':id', callback: 'update', params: Request::body());
	$route->get(callback: 'getAll');
	$route->get(endpoint: ':id', callback: 'getById');
	$route->delete(endpoint: ':id', callback: 'delete');
});
