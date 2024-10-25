<?php

namespace App\Api\Modules\Property\Entity;

use App\Api\Modules\Property\PropertyDto;
use App\Api\Shared\Database\Connection;

class PropertyEntity
{
    private readonly int $propertyid;

    public function __construct(
        private readonly Connection $connection = new Connection()
    ) {}

    public function create(PropertyDto $propertyDto)
    {
        $this->connection->query(
            "INSERT INTO properties (name, cep, neighborhood, address_number, complement, city, uf, description)
            VALUES (:name, :cep, :neighborhood, :address_number, :complement, :city, :uf, :description)",
            [
                'name' => $propertyDto->name,
                'cep' => $propertyDto->cep,
                'neighborhood' => $propertyDto->neighborhood,
                'address_number' => $propertyDto->address_number,
                'complement' => $propertyDto->complement,
                'city' => $propertyDto->city,
                'uf' => $propertyDto->uf,
                'description' => $propertyDto->description,
            ]
        );

        $this->propertyid = $this->connection->lastInsertedId;

        if (!empty($propertyDto->clientid)) {
            $this->connection->query(
                "INSERT INTO client_properties (clientid, propertyid) VALUES (:clientid, :propertyid)",
                [
                    'clientid' => $propertyDto->clientid,
                    'propertyid' => $this->propertyid
                ]
            );
        }
		if (!empty($propertyDto->amenities)) {
			foreach ($propertyDto->amenities as $amenityId) {
				$this->connection->query(
					"INSERT INTO properties_amenities (propertyid, amenityid) VALUES (:propertyid, :amenityid)",
					[
						'propertyid' => $this->propertyid,
						'amenityid' => $amenityId
					]
				);
			}
		}
        return $this->propertyid;
    }

	public function selectAll()
	{
		return $this->connection->query(
			"SELECT p.id, p.name, p.cep, p.neighborhood, p.address_number, p.complement, p.city, p.uf, p.description,
				cp.clientid, c.cpf, c.name AS client_name,
				array_agg(a.name) AS amenities
			FROM properties p
			JOIN client_properties cp ON p.id = cp.propertyid
			JOIN clients c ON cp.clientid = c.id
			LEFT JOIN properties_amenities pa ON p.id = pa.propertyid
			LEFT JOIN amenities a ON pa.amenityid = a.id
			GROUP BY p.id, cp.clientid, c.cpf, c.name"
		);
	}


    public function selectById(int $id)
    {
        return $this->connection->query(
            "SELECT p.name, p.cep, p.neighborhood, p.address_number, p.complement, p.city, p.uf, p.description,
                cp.clientid, c.cpf, c.name AS client_name,
                array_agg(a.name) AS amenities
            FROM properties p
            JOIN client_properties cp ON p.id = cp.propertyid
            JOIN clients c ON cp.clientid = c.id
            LEFT JOIN properties_amenities pa ON p.id = pa.propertyid
            LEFT JOIN amenities a ON pa.amenityid = a.id
            WHERE p.id = :id
            GROUP BY p.name, p.cep, p.neighborhood, p.address_number, p.complement, p.city, p.uf, p.description,
                        cp.clientid, c.cpf, c.name",
            ['id' => $id]
        );
    }

    public function delete(int $id)
    {
        $this->connection->query("DELETE FROM client_properties WHERE propertyid = :id", ['id' => $id]);
        return $this->connection->query("DELETE FROM properties WHERE id = :id", ['id' => $id]);
    }

    public function update(int $id, PropertyDto $propertyDto)
    {
        return $this->connection->query(
            "UPDATE properties SET name = :name, cep = :cep, neighborhood = :neighborhood, address_number = :address_number, complement = :complement, city = :city, uf = :uf, description = :description WHERE id = :id",
            [
                'name' => $propertyDto->name,
                'cep' => $propertyDto->cep,
                'neighborhood' => $propertyDto->neighborhood,
                'address_number' => $propertyDto->address_number,
                'complement' => $propertyDto->complement,
                'city' => $propertyDto->city,
                'uf' => $propertyDto->uf,
                'description' => $propertyDto->description,
                'id' => $id
            ]
        );
    }
}
