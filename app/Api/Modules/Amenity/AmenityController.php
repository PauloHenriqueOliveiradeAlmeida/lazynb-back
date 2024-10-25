<?php

namespace App\Api\Modules\Amenity;

use App\Api\Modules\Amenity\Dtos\AmenityDto;
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


#[Controller(endpoint: 'amenities')]
class AmenityController
{
	public function __construct(
		private readonly AmenityService $amenityService = new AmenityService()
	) {}

	#[Get]
	#[UseGuard(new UserGuard(UserLevelEnum::ADMIN))]
	public function getAll()
	{
		return $this->amenityService->getAll();
	}
	#[Post]
	#[UseGuard(new UserGuard(UserLevelEnum::ADMIN))]
	public function create(#[Body] AmenityDto $amenityDto)
	{
		return $this->amenityService->create($amenityDto);
	}
	#[Delete(endpoint: ':id')]
	#[UseGuard(new UserGuard(UserLevelEnum::ADMIN))]
	public function delete(#[Param(paramName: 'id')] int $id)
	{
		return $this->amenityService->delete($id);
	}
}
?>
