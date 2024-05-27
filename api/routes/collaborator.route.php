<?php

require_once __DIR__ . "/../packages/route/route.php";
require_once  __DIR__ . "/../controllers/collaborator/collaborator.controller.php";


Route::endpoint('/collaborators', CollaboratorController::class)->methods(function(Route $route) {
	$route->post('create', $_POST);
	$route->put(endpoint: ':id', callback: 'update', params: $_POST);
	$route->patch(endpoint: ':id', callback: 'patch', params: $_POST);
	$route->get('getAll');
	$route->get(endpoint: ':id', callback: 'getById');
	$route->delete(endpoint: ':id', callback: 'delete');
});
