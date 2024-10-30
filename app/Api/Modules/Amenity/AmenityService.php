<?php

namespace App\Api\Modules\Amenity;

use App\Api\Modules\Amenity\Dtos\AmenityDto;
use App\Api\Modules\Amenity\Entity\AmenityEntity;
use PDOException;
use Raven\Falcon\Http\Exceptions\BadRequestException;
use Raven\Falcon\Http\Response;
use Raven\Falcon\Http\StatusCode;

class AmenityService
{

	public function __construct(private readonly AmenityEntity $amenityEntity = new AmenityEntity) {}

	public function create(AmenityDto $amenityDto)
	{
		try {
			$this->amenityEntity->create($amenityDto);
			return Response::sendBody([
				"message" => "Comodidade criada com sucesso"
			], StatusCode::CREATED);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function getAll()
	{
		try {
			$amenities = $this->amenityEntity->selectAll();
			return Response::sendBody($amenities);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function connectAmenity($data)
	{
		$property_id = $data['property_id'];
		$amenities = $data['amenities'];

		try {
			foreach ($amenities as $amenity) {
				$this->amenityEntity->addAmenityToProperty($property_id, $amenity);
			}
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}
	public  function delete(int $id)
	{
		try {
			$deletedAmenity = $this->amenityEntity->delete($id);

			if (!$deletedAmenity) throw new BadRequestException('Comodidade não encontrada');

			Response::sendBody([
				"message" => "Comodidade excluída com sucesso"
			]);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}
}
