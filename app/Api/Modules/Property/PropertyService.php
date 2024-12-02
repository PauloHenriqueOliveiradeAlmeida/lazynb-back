<?php

namespace App\Api\Modules\Property;

use App\Api\Modules\Property\Entity\PropertyEntity;
use App\Api\Modules\Amenity\Entity\AmenityEntity;
use App\Api\Modules\Property\Dtos\PropertyDto;
use App\Api\Shared\Services\Cep\CepService;
use App\Api\Shared\Services\Cep\ICep;
use Exception;
use Raven\Falcon\Http\Response;
use Raven\Falcon\Http\StatusCode;
use PDOException;
use Raven\Falcon\Http\Exceptions\BadRequestException;
use Raven\Falcon\Http\Exceptions\NotFoundException;

class PropertyService
{
	private readonly CepService $cepService;
	public function __construct(
		private readonly ICep $cepGateway,
		private readonly PropertyEntity $propertyEntity = new PropertyEntity,
		private readonly AmenityEntity $amenityEntity = new AmenityEntity
	) {
		$this->cepService = new CepService($this->cepGateway);
	}

	public function create(PropertyDto $propertyDto)
	{
		try {
			$propertyDto->complement = $propertyDto->complement ?? null;

			$propertyWithoutAmenities = clone $propertyDto;
			unset($propertyWithoutAmenities->amenities);
			$propertyId = $this->propertyEntity->create($propertyWithoutAmenities);

			if (isset($propertyDto->amenities) && !empty($propertyDto->amenities)) {
				$this->propertyEntity->connectAmenities($propertyDto->amenities, $propertyId);
			}

			return Response::sendBody([
				"message" => "Propriedade criada com sucesso"
			], StatusCode::CREATED);
		} catch (Exception $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function getAll()
	{
		try {
			$properties = $this->propertyEntity->selectAll();
			return Response::sendBody($properties);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function getById(int $id)
	{
		try {
			$property = $this->propertyEntity->selectById($id);

			if (!$property) throw new NotFoundException('Propriedade não encontrada');

			Response::sendBody($property);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function update(int $id, PropertyDTO $propertyDto)
	{
		try {
			$existingProperty = $this->propertyEntity->selectById($id);
			if (!$existingProperty) throw new NotFoundException("Propriedade não encontrada");

			$propertyDto->complement = $propertyDto->complement ?? null;
			$propertyWithoutAmenities = clone $propertyDto;
			unset($propertyWithoutAmenities->amenities);
			$this->propertyEntity->update($id, $propertyWithoutAmenities);

			if (isset($propertyDto->amenities) && !empty($propertyDto->amenities)) {
				$this->syncAmenities($id, $propertyDto->amenities);
			}

			return Response::sendBody([
				"message" => "Propriedade atualizada com sucesso"
			]);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function delete(int $id)
	{
		try {
			$deletedProperty = $this->propertyEntity->delete($id);

			if (!$deletedProperty) throw new NotFoundException("Propriedade não encontrada");

			return Response::sendBody([
				"message" => "Propriedade removida com sucesso"
			]);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function getAddressByCep(string $cep)
	{
		return Response::sendBody((array)$this->cepService->getAddress($cep));
	}

	private function syncAmenities(int $propertyId, array $newAmenities)
	{
		$currentAmenities = $this->amenityEntity->selectByPropertyId($propertyId);

		$toDelete = array_filter(
			$currentAmenities,
			fn($amenity) => !in_array($amenity['id'], $newAmenities)
		);

		$toAdd = array_filter(
			$newAmenities,
			fn($amenityId) => !in_array($amenityId, array_column($currentAmenities, 'id'))
		);

		if (!empty($toDelete)) {
			$this->amenityEntity->deleteMany(array_column($toDelete, 'id'));
		}

		$this->connectAmenities($propertyId, $toAdd);
	}

	private function connectAmenities(int $propertyId, array $amenities)
	{
		foreach ($amenities as $amenityId) {
			$this->amenityEntity->addAmenityToProperty($propertyId, $amenityId);
		}
	}
}
