<?php

require_once __DIR__ . "/../../shared/auth/auth.service.php";
require_once __DIR__ . "/../../shared/packages/route/route.php";
require_once __DIR__ . "/../../shared/packages/request/request.php";
require_once "property.controller.php";

Route::endpoint('/properties', PropertyController::class)->withAuth(Auth::class)->methods(function(Route $route) {

	$route->post('create', params: Request::body());
	$route->put(endpoint: ':id', callback: 'update', params: Request::body());
	$route->patch(endpoint: ':id', callback: 'patch', params: Request::body());
	$route->get('getAll');
	$route->get(endpoint: ':id', callback: 'getById');
	$route->get(endpoint: ':clientid', callback: 'getByClientId');
	$route->delete(endpoint: ':id', callback: 'delete');
	$route->post(endpoint: 'login', callback: 'login', params: Request::body());

});
