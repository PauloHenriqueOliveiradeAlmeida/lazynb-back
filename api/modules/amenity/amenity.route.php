<?php

require_once __DIR__ . "/../../shared/auth/auth.service.php";
require_once __DIR__ . "/../../shared/packages/route/route.php";
require_once __DIR__ . "/../../shared/packages/request/request.php";
require_once "amenity.controller.php";

Route::endpoint('/amenities', AmenityController::class)->withAuth(Auth::class)->methods(function(Route $route) {

	$route->post('processAmenities', params: Request::body());
	$route->post(endpoint: 'login', callback: 'login', params: Request::body());

});
