<?php

namespace App\Api\Modules\Amenity\Entity;

use App\Api\Modules\Amenity\Dtos\AmenityDTO;
use App\Api\Shared\Database\Connection;

class AmenityEntity
{
	private readonly int $id;

	public function __construct(
		private readonly Connection $connection = new Connection()
	) {}

	public function create(AmenityDTO $amenityDto)
	{
		return $this->connection->query(
			"INSERT INTO amenities (name) VALUES (:name)",
			[...(array) $amenityDto]
		);
		$this->id = $this->connection->lastInsertedId;
	}

	public function selectAll()
	{
		return $this->connection->query("SELECT * FROM amenities");
	}

	public function selectByAmenityId(int $amenityId)
	{
		return $this->connection->query("SELECT * FROM properties_amenities
		JOIN amenities ON properties_amenities.amenityId = amenities.id
		WHERE properties_amenities.amenityId = :amenityId", ['amenityId' => $amenityId]);

	}

	public function selectByPropertyId(int $propertyId)
    {
        return $this->connection->query(
            "SELECT a.id, a.name
            FROM properties_amenities pa
            JOIN amenities a ON pa.amenityId = a.id
            WHERE pa.propertyId = :propertyId",
            ['propertyId' => $propertyId]
        );
    }

	public function findByName(string $name)
	{
		$this->connection->query("SELECT * FROM amenities WHERE name = :name",['name' => $name]);
	}

	public function addAmenityToProperty($propertyId, $amenityId)
	{
		$this->connection->query("INSERT INTO properties_amenities (propertyId, amenityId) VALUES (:propertyId, :amenityId)",
		['propertyId' => $propertyId, 'amenityId' => $amenityId]);
	}

	public function delete($id)
	{
		return $this->connection->query("DELETE FROM amenities WHERE id = :id", ['id' => $id]);
	}

	public function deleteMany(array $ids)
	{
		$placeholders = rtrim(str_repeat('?,', count($ids)), ',');

		$query = "DELETE FROM properties_amenities WHERE amenityId IN ($placeholders)";

		return $this->connection->query($query, $ids);
	}
}
