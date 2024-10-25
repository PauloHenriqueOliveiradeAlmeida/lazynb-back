<?php

namespace App\Api\Modules\Property;

use App\Api\Modules\Property\Entity\PropertyEntity;
use App\Api\Modules\Amenity\Entity\AmenityEntity;
use Exception;
use Raven\Falcon\Http\Response;
use Raven\Falcon\Http\StatusCode;
use PDOException;
use Raven\Falcon\Http\Exceptions\BadRequestException;
use Raven\Falcon\Http\Exceptions\NotFoundException;

class PropertyService
{
    public function __construct(
        private readonly PropertyEntity $propertyEntity = new PropertyEntity,
        private readonly AmenityEntity $amenityEntity = new AmenityEntity
    ) {}

    public function create(PropertyDto $propertyDto)
    {
        try {
			$this->propertyEntity->create($propertyDto);

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

            $this->propertyEntity->update($id, $propertyDto);

            if (!empty($propertyDto->amenities)) {
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

    private function connectAmenities(int $propertyId, array $amenities)
    {
        foreach ($amenities as $amenityId) {
            $this->amenityEntity->addAmenityToProperty($propertyId, $amenityId);
        }
    }

    private function syncAmenities(int $propertyId, array $newAmenities)
    {
        $currentAmenities = $this->amenityEntity->selectByPropertyId($propertyId);

        $toDelete = array_filter($currentAmenities, function ($amenity) use ($newAmenities) {
            return !in_array($amenity['id'], $newAmenities);
        });

        $toAdd = array_filter($newAmenities, function ($amenityId) use ($currentAmenities) {
            return !in_array($amenityId, array_column($currentAmenities, 'id'));
        });

        if (!empty($toDelete)) {
            $this->amenityEntity->deleteMany(array_column($toDelete, 'id'));
        }

        $this->connectAmenities($propertyId, $toAdd);
    }
}
