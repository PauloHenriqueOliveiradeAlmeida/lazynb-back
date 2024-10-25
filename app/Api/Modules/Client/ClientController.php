<?php

namespace App\Api\Modules\Client;

use App\Api\Modules\Client\ClientService;
use App\Api\Shared\Guards\Enums\UserLevelEnum;
use App\Api\Shared\Guards\UserGuard;
use Raven\Falcon\Attributes\Controller;
use Raven\Falcon\Attributes\HttpMethods\Delete;
use Raven\Falcon\Attributes\HttpMethods\Get;
use Raven\Falcon\Attributes\HttpMethods\Post;
use Raven\Falcon\Attributes\HttpMethods\Put;
use Raven\Falcon\Attributes\Middlewares\Guard\UseGuard;
use Raven\Falcon\Attributes\Request\Body;
use Raven\Falcon\Attributes\Request\Param;

#[Controller(endpoint: 'clients')]
class ClientController
{

	public function __construct(
		private readonly ClientService $clientService = new ClientService()
	) {}

	#[Post]
	#[UseGuard(new UserGuard(UserLevelEnum::ADMIN))]
	public function create(#[Body] ClientDto $clientDto)
	{
		return $this->clientService->create($clientDto);
	}

	#[Put(endpoint: ':id')]
	#[UseGuard(new UserGuard(UserLevelEnum::ADMIN))]
	public function update(#[Body] ClientDto $clientDto, #[Param(paramName: 'id')] int $id)
	{
		return $this->clientService->update($id, $clientDto);
	}

	#[Get]
	#[UseGuard(new UserGuard(UserLevelEnum::ADMIN))]
	public function getAll()
	{
		return $this->clientService->getAll();
	}

	#[Get(endpoint: ':id')]
	#[UseGuard(new UserGuard(UserLevelEnum::ADMIN))]
	public function getOne(#[Param(paramName: 'id')] int $id)
	{
		return $this->clientService->getById($id);
	}

	#[Delete(endpoint: ':id')]
	#[UseGuard(new UserGuard(UserLevelEnum::ADMIN))]
	public function delete(#[Param(paramName: 'id')] int $id)
	{
		return $this->clientService->delete($id);
	}
}
