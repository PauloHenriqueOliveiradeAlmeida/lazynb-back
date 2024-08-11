<?php

namespace App\Api\Posts;

use Raven\Falcon\Attributes\Controller;
use Raven\Falcon\Attributes\HttpMethods\Post;
use Raven\Falcon\Attributes\HttpMethods\Put;
use Raven\Falcon\Attributes\HttpMethods\Patch;
use Raven\Falcon\Attributes\HttpMethods\Get;
use Raven\Falcon\Attributes\HttpMethods\Delete;
use Raven\Falcon\Http\Response;

#[Controller(endpoint: "posts")]
class PostsController
{
	#[Post]
	public function create()
	{
		return Response::sendBody([
			"Created" => true,
		]);
	}

	#[Put(endpoint: ":id")]
	public function update(int $id)
	{
		return Response::sendBody([
			"Updated Posts with id" => $id,
		]);
	}

	#[Patch(endpoint: ":id")]
	public function partialUpdate(int $id)
	{
		return Response::sendBody([
			"Updated partially Posts with id" => $id,
		]);
	}

	#[Get]
	public function getAll()
	{
		return Response::sendBody([
			"Searched all Posts" => true,
		]);
	}

	#[Get(endpoint: ":id")]
	public function getOne(int $id)
	{
		return Response::sendBody([
			"Searched Posts with id" => $id,
		]);
	}

	#[Delete(endpoint: ":id")]
	public function delete(int $id)
	{
		return Response::sendBody([
			"Deleted Posts with id" => $id,
		]);
	}
}
