<?php

namespace App\Api\Modules\Client\Entity;

use App\Api\Shared\Database\Connection;

class ClientEntity
{
	private readonly string $name;
	private readonly string $CPF;
	private readonly string $phone_number;
	private readonly string $email;


	public function __construct(?string $name = '', ?string $CPF = '', ?string $phone_number = '', ?string $email = '')
	{
		$this->name = $name;
		$this->CPF = $CPF;
		$this->phone_number = $phone_number;
		$this->email = $email;
	}

	public function create()
	{
		$connection = new Connection();

		$query = $connection->queryDB(
			"INSERT INTO clients (name, CPF, phone_number, email) VALUES (?, ?, ?, ?)",
			[
				$this->name,
				$this->CPF,
				$this->phone_number,
				$this->email,
			]
		);
		return $query;
	}

	public function selectAll()
	{
		$connection = new Connection();
		$query = $connection->queryDB("SELECT id, name, email, phone_number, CPF FROM clients");
		return $query->fetch_all(MYSQLI_ASSOC);
	}

	public static function selectById($id)
	{
		$connection = new Connection();
		$query = $connection->queryDB("SELECT name, email, phone_number, CPF FROM clients WHERE id = ?", [$id]);
		return $query->fetch_assoc() ?? [];
	}

	public function delete($id)
	{
		$connection = new Connection();
		$query = $connection->queryDB("DELETE FROM clients WHERE id = ?", [$id]);
		return $query;
	}

	public function update($id)
	{
		$connection = new Connection();
		$query = $connection->queryDB(
			"UPDATE clients SET name=?, CPF=?, phone_number=?, email=? WHERE id = ?",
			[
				$this->name,
				$this->CPF,
				$this->phone_number,
				$this->email,
				$id
			]
		);
		return $query;
	}
}
