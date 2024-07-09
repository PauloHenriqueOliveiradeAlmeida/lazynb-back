<?php

namespace App\Api\Users;

use Raven\Http\Response;
use Raven\Http\StatusCode;

class UserController
{
	public static function getOne(int $account)
	{
		return Response::sendBody([
			"message" => $account
		], StatusCode::OK);
	}

	public static function getAll()
	{
		return Response::sendBody([
			"message" => "Hello World"
		], StatusCode::OK);
	}
}
