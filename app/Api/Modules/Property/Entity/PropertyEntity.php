<?php

namespace App\Api\Modules\Property\Entity;

use App\Api\Modules\Property\PropertyDto;
use App\Api\Shared\Database\Connection;

class PropertyEntity
{

	public function __construct(
		private readonly Connection $connection = new Connection()
	) {}

	public function create(PropertyDto $propertyDto)
	{
		$this->connection->query(
			"INSERT INTO properties (name, cep, neighborhood, address_number, complement, city, uf, description, clientid)
            VALUES (:name, :cep, :neighborhood, :address_number, :complement, :city, :uf, :description, :clientid)",
			(array) $propertyDto
		);

		return $this->connection->lastInsertedId;
	}

	public function selectAll()
	{
		$query = $this->connection->query(
			"SELECT p.id, p.name, p.cep, p.neighborhood, p.address_number, p.complement, p.city, p.uf, p.description, p.clientid, c.cpf
			, c.name AS client_name, CASE WHEN COUNT(a.name) > 0 THEN array_agg(a.name) ELSE NULL END AS amenities
			FROM properties p JOIN clients c ON p.clientid = c.id LEFT JOIN properties_amenities pa ON p.id = pa.propertyid LEFT JOIN
			amenities a ON pa.amenityid = a.id GROUP BY p.id, c.id"
		);

		return array_map(
			fn($row) => $row['amenities'] !== null ?
				[...$row, 'amenities' =>
				str_replace(['{', '}'], '', explode(',', $row['amenities']))] : $row,
			$query
		);
	}


	public function selectById(int $id)
	{
		$query = $this->connection->query(
			"SELECT p.id, p.name, p.cep, p.neighborhood, p.address_number, p.complement, p.city, p.uf, p.description, p.clientid, c.cpf
			, c.name AS client_name, CASE WHEN COUNT(a.name) > 0 THEN array_agg(a.name) ELSE NULL END AS amenities
			FROM properties p JOIN clients c ON p.clientid = c.id LEFT JOIN properties_amenities pa ON p.id = pa.propertyid LEFT JOIN
			amenities a ON pa.amenityid = a.id
			WHERE p.id = :id GROUP BY p.id, c.id",
			['id' => $id]
		);

		return array_map(
			fn($row) => $row['amenities'] !== null ?
				[...$row, 'amenities' =>
				str_replace(['{', '}'], '', explode(',', $row['amenities']))] : $row,
			$query
		);
	}

	public function delete(int $id)
	{
		$this->connection->query("DELETE FROM properties_amenities WHERE propertyid = :id", ['id' => $id]);
		return $this->connection->query("DELETE FROM properties WHERE id = :id", ['id' => $id]);
	}

	public function update(int $id, PropertyDto $propertyDto)
	{
		return $this->connection->query(
			"UPDATE properties SET name = :name, cep = :cep, neighborhood = :neighborhood, address_number = :address_number, complement = :complement, city = :city, uf = :uf, description = :description, clientid = :clientid WHERE id = :id",
			[
				...(array) $propertyDto,
				'id' => $id
			]
		);
	}

	/** @param array<int> $amenities */
	public function connectAmenities(array $amenities, int $propertyId)
	{
		foreach ($amenities as $amenityId) {
			$this->connection->query(
				"INSERT INTO properties_amenities (propertyid, amenityid) VALUES (:propertyid, :amenityid)",
				[
					'propertyid' => $propertyId,
					'amenityid' => $amenityId
				]
			);
		}

		return true;
	}
}
