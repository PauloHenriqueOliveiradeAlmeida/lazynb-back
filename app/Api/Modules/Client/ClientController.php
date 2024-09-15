<?php

namespace App\Api\Modules\Client;

use Raven\Falcon\Attributes\Controller;
use Raven\Falcon\Attributes\HttpMethods\Delete;
use Raven\Falcon\Attributes\HttpMethods\Get;
use Raven\Falcon\Attributes\HttpMethods\Post;
use Raven\Falcon\Attributes\HttpMethods\Put;
use Raven\Falcon\Attributes\Request\Body;
use Raven\Falcon\Attributes\Request\Param;

#[Controller(endpoint: 'clients')]
class ClientController
{

	public function __construct(
		private readonly ClientService $clientService = new ClientService()
	) {}

	#[Post]
	public function create(#[Body] ClientDto $clientDto)
	{
		return $this->clientService->create($clientDto);
	}

	#[Put(endpoint: ':id')]
	public function update(#[Body] ClientDto $clientDto, #[Param(paramName: 'id')] int $id)
	{
		return $this->clientService->update($id, $clientDto);
	}

	#[Get]
	public function getAll()
	{
		return $this->clientService->getAll();
	}

	#[Get(endpoint: ':id')]
	public function getOne(#[Param(paramName: 'id')] int $id)
	{
		return $this->clientService->getById($id);
	}

	#[Delete(endpoint: ':id')]
	public function delete(#[Param(paramName: 'id')] int $id)
	{
		return $this->clientService->delete($id);
	}
}
