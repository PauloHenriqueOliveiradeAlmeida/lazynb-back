<?php

namespace App\Api\Users;

use Raven\Falcon\Attributes\Controller;
use Raven\Falcon\Attributes\HttpMethods\Get;
use Raven\Falcon\Http\Response;

#[Controller(endpoint: '/api/users')]
class UserController
{
	#[Get]
	public function getAll()
	{
		return Response::sendBody([
			"Hello" => "World"
		]);
	}

	#[Get(endpoint: ':id')]
	public function getOne(int $id)
	{
		return Response::sendBody([
			"Hello" => $id
		]);
	}
}
