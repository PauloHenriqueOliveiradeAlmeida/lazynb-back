<?php

require_once "database/connection.php";

class Property
{
	private readonly string $name;
	private readonly string $CEP;
	private readonly string $neighborhood;
	private readonly string $number;
	private readonly string $complement;
	private readonly string $city;
	private readonly string $UF;
	private readonly string $description;

	public function __construct(?string $name = '', ?string $CEP = '', ?string $neighborhood = '', ?string $number = '',  ?string $complement = '', ?string $city = '', ?string $UF = '', ?string $description = '')
	{
		$this->name = $name;
		$this->CEP = $CEP;
		$this->neighborhood = $neighborhood;
		$this->number = $number;
		$this->complement = $complement;
		$this->city = $city;
		$this->UF = $UF;
		$this->description = $description;
	}

	public function create($id)
	{
		$connection = new Connection();

		$query = $connection->queryDB(
			"INSERT INTO properties (name, CEP, neighborhood, number, complement, city, UF, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
			[
				$this->name,
				$this->CEP,
				$this->neighborhood,
				$this->number,
				$this->complement,
				$this->city,
				$this->UF,
				$this->description
			]
		);

		if ($query) {
			$propertyId = $connection->getLastInsertId();

			$linkQuery = $connection->queryDB(
				"INSERT INTO client_properties (clientId, propertyId) VALUES (?, ?)",
				[
					$id,
					$propertyId
				]
			);

			if ($linkQuery) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		return $query;
	}

	public function selectAll()
	{
		$connection = new Connection();
		$query = $connection->queryDB("SELECT id, name, CEP, neighborhood, number, complement, city, UF, description FROM properties");
		return $query->fetch_all(MYSQLI_ASSOC);
	}

	public static function selectById($id)
	{
		$connection = new Connection();
		$query = $connection->queryDB("SELECT id, name, CEP, neighborhood, number, complement, city, UF, description FROM properties WHERE id = ?", [$id]);
		return $query->fetch_assoc() ?? [];
	}

	public function delete($id)
	{
		$connection = new Connection();
		$query = $connection->queryDB("DELETE FROM properties WHERE id = ?", [$id]);
		return $query;
	}

	public function update($id)
	{
		$connection = new Connection();
		$query = $connection->queryDB(
			"UPDATE properties SET name=?, CEP=?, neighborhood=?, number=?, complement=?, city=?, UF=?, description=? WHERE id = ?",
			[
				$this->name,
				$this->CEP,
				$this->neighborhood,
				$this->number,
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
