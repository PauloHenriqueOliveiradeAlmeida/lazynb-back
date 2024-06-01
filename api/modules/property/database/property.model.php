<?php

require_once __DIR__ . "/../../../shared/database/connection.php";

class Property
{
	private readonly string $name;
	private readonly string $CEP;
	private readonly string $neighborhood;
	private readonly string $adress_number;
	private readonly string $complement;
	private readonly string $city;
	private readonly string $UF;
	private readonly string $description;
	private readonly int $id;

	public function __construct(?string $name = '', ?string $CEP = '', ?string $neighborhood = '', ?string $adress_number = '',  ?string $complement = '', ?string $city = '', ?string $UF = '', ?string $description = '', ?int $id = 0)
	{
		$this->name = $name;
		$this->CEP = $CEP;
		$this->neighborhood = $neighborhood;
		$this->adress_number = $adress_number;
		$this->complement = $complement;
		$this->city = $city;
		$this->UF = $UF;
		$this->description = $description;
		$this->id = $id;
	}

	public function create()
	{
		$connection = new Connection();

		$query = $connection->queryDB(
			"INSERT INTO properties (name, CEP, neighborhood, adress_number, complement, city, UF, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
			[
				$this->name,
				$this->CEP,
				$this->neighborhood,
				$this->adress_number,
				$this->complement,
				$this->city,
				$this->UF,
				$this->description
				]
			);

			$propertyId = $connection->getLastInsertId();

		$connection->queryDB(
			"INSERT INTO client_properties (clientId, propertyId) VALUES (?, ?)",
			[
				$this->id,
				$propertyId
			]
		);
		return $query;
	}

	public function selectAll()
	{
		$connection = new Connection();
		$query = $connection->queryDB(
			"SELECT p.id, p.name, p.CEP, p.neighborhood, p.adress_number, p.complement, p.city, p.UF, p.description, cp.clientId
			FROM properties p
			JOIN client_properties cp ON p.id = cp.propertyId"
		);
		$result = $query->fetch_all(MYSQLI_ASSOC);
		if (!$result){
			throw new Exception('Fetch failed');
		}
		return $result;
	}

	public static function selectById($id)
	{
		$connection = new Connection();
		$query = $connection->queryDB(
			"SELECT p.id, p.name, p.CEP, p.neighborhood, p.adress_number, p.complement, p.city, p.UF, p.description, cp.clientId
			FROM properties p
			JOIN client_properties cp ON p.id = cp.propertyId
			WHERE p.id = ?",
			[$id]
		);
		return $query->fetch_assoc() ?? [];
	}
	public function selectByClientId($clientId)
	{
		$connection = new Connection();
		$query = $connection->queryDB(
			"SELECT p.id, p.name, p.CEP, p.neighborhood, p.adress_number, p.complement, p.city, p.UF, p.description
			FROM properties p
			JOIN client_properties cp ON p.id = cp.propertyId
			WHERE cp.clientId = ?",
			[$clientId]
		);
		return $query->fetch_all(MYSQLI_ASSOC);
	}
	public function delete($id)
	{
		$connection = new Connection();
		$connection->queryDB("DELETE FROM client_properties WHERE propertyId = ?", [$id]);
		$query = $connection->queryDB("DELETE FROM properties WHERE id = ?", [$id]);
		return $query;
	}

	public function update($id)
	{
		$connection = new Connection();
		$query = $connection->queryDB(
			"UPDATE properties SET name=?, CEP=?, neighborhood=?, adress_number=?, complement=?, city=?, UF=?, description=? WHERE id = ?",
			[
				$this->name,
				$this->CEP,
				$this->neighborhood,
				$this->adress_number,
				$this->complement,
				$this->city,
				$this->UF,
				$this->description,
				$id
			]
		);
		return $query;
	}
}
