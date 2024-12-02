<?php

namespace App\Api\Modules\Property;

use App\Api\Modules\Property\Dtos\PropertyDto;
use App\Api\Modules\Property\PropertyService;
use App\Api\Shared\Guards\Enums\UserLevelEnum;
use App\Api\Shared\Guards\UserGuard;
use App\Api\Shared\Services\Cep\Gateways\ViacepGateway;
use Raven\Falcon\Attributes\Controller;
use Raven\Falcon\Attributes\HttpMethods\Delete;
use Raven\Falcon\Attributes\HttpMethods\Get;
use Raven\Falcon\Attributes\HttpMethods\Post;
use Raven\Falcon\Attributes\HttpMethods\Put;
use Raven\Falcon\Attributes\Middlewares\Guard\UseGuard;
use Raven\Falcon\Attributes\Request\Body;
use Raven\Falcon\Attributes\Request\Param;

#[Controller(endpoint: 'properties')]
class PropertyController
{
	public function __construct(
		private readonly PropertyService $propertyService = new PropertyService(new ViacepGateway)
	) {}

	#[Post]
	#[UseGuard(new UserGuard(UserLevelEnum::ADMIN))]
	public function create(#[Body] PropertyDto $propertyDto)
	{
		return $this->propertyService->create($propertyDto);
	}

	#[Put(endpoint: ':id')]
	#[UseGuard(new UserGuard(UserLevelEnum::ADMIN))]
	public function update(#[Body] PropertyDto $propertyDto, #[Param(paramName: 'id')] int $id)
	{
		return $this->propertyService->update($id, $propertyDto);
	}

	#[Get]
	#[UseGuard(new UserGuard(UserLevelEnum::ALL))]
	public function getAll()
	{
		return $this->propertyService->getAll();
	}

	#[Get(endpoint: ':id')]
	#[UseGuard(new UserGuard(UserLevelEnum::ALL))]
	public function get(#[Param(paramName: 'id')] int $id)
	{
		return $this->propertyService->getById($id);
	}

	#[Delete(endpoint: ':id')]
	#[UseGuard(new UserGuard(UserLevelEnum::ADMIN))]
	public function delete(#[Param(paramName: 'id')] int $id)
	{
		return $this->propertyService->delete($id);
	}

	#[Get(endpoint: ':cep/address')]
	#[UseGuard(new UserGuard(UserLevelEnum::ADMIN))]
	public function getAddressByCep(#[Param(paramName: 'cep')] string $cep)
	{
		return $this->propertyService->getAddressByCep($cep);
	}
}
