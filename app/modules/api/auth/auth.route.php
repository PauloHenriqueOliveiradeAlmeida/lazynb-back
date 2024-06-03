<?php

require_once __DIR__ . "/../../../shared/packages/route/route.php";
require_once __DIR__ . "/../../../shared/packages/request/request.php";
require_once __DIR__ . "/../collaborator/collaborator.controller.php";

Route::endpoint('/auth', CollaboratorController::class)->methods(function(Route $route) {
	$route->post(endpoint: 'login', callback: 'login', params: Request::body());
	$route->get(endpoint: 'logout', callback: 'logout');
});
