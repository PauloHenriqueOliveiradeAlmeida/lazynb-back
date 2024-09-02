<?php

namespace App\Api\Modules\Client;

use Raven\Falcon\Attributes\Controller;
use Raven\Falcon\Attributes\HttpMethods\Delete;
use Raven\Falcon\Attributes\HttpMethods\Get;
use Raven\Falcon\Attributes\HttpMethods\Post;
use Raven\Falcon\Attributes\HttpMethods\Put;

#[Controller(endpoint: 'clients')]
class ClientController {

	public function __construct(
		private readonly ClientService $clientService = new ClientService()
	) {}


	#[Post]
	public function create() {
		return $this->clientService->create(Request::body());
	}

	#[Put(endpoint: ':id')]
	public function update(int $id) {
		return $this->clientService->update($id, Request::body());
	}

	#[Get]
	public function getAll() {
		return $this->clientService->getAll();
	}

	#[Get(endpoint: ':id')]
	public function getOne(int $id) {
		return $this->clientService->getById($id);
	}

	#[Delete(':id')]
	public function delete(int $id) {
		return $this->clientService->delete($id);
	}
}
