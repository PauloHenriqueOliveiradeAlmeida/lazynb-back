<?php

require_once __DIR__ . "/../../../../shared/database/connection.php";

class Collaborator
{
	private readonly string $name;
	private readonly string $CPF;
	private readonly string $phone_number;
	private readonly string $email;
	private readonly string $password;
	private readonly int $is_admin;


	public function __construct(?string $name = '', ?string $CPF = '', ?string $phone_number = '', ?string $email = '', ?int $is_admin = 0, ?string $password = '')
	{
		$this->name = $name;
		$this->CPF = $CPF;
		$this->phone_number = $phone_number;
		$this->email = $email;
		$this->is_admin = $is_admin;
		$this->password = $password;
	}

	public function create()
	{
		$connection = new Connection();
		$query = $connection->queryDB(
			"INSERT INTO collaborators (name, CPF, phone_number, email, is_admin, password) VALUES (?, ?, ?, ?, ?, ?)",
			[
				$this->name,
				$this->CPF,
				$this->phone_number,
				$this->email,
				$this->is_admin,
				$this->password
			]
		);
		return $query;
	}

	public function selectAll()
	{
		$connection = new Connection();
		$query = $connection->queryDB("SELECT id, name, email, phone_number, CPF, is_admin FROM collaborators");
		return $query->fetch_all(MYSQLI_ASSOC);
	}

	public function selectById($id)
	{
		$connection = new Connection();
		$query = $connection->queryDB("SELECT id, name, email, phone_number, CPF, is_admin FROM collaborators WHERE id = ?", [$id]);
		return $query->fetch_assoc() ?? [];
	}

	public function selectByEmail(string $email) {
		$connection = new Connection();
		$query = $connection->queryDB("SELECT id, name, email, password, is_admin from collaborators WHERE email=?", [
			$email
		]);

		return $query->fetch_assoc() ?? [];
	}

	public function delete($id)
	{
		$connection = new Connection();
		$query = $connection->queryDB("DELETE FROM collaborators WHERE id = ?", [$id]);
		return $query;
	}

	public function update($id)
	{
		$connection = new Connection();
		$query = $connection->queryDB(
			"UPDATE collaborators SET name=?, CPF=?, phone_number=?, email=?, password=?, is_admin=? WHERE id = ?",
			[
				$this->name,
				$this->CPF,
				$this->phone_number,
				$this->email,
				$this->is_admin,
				$this->password,
				$id
			]
		);
		return $query;
	}

	public function patch($id)
	{
		$connection = new Connection();
		$query = $connection->queryDB(
			"UPDATE collaborators SET name=?, CPF=?, phone_number=?, email=?, is_admin=? WHERE id = ?",
			[
				$this->name,
				$this->CPF,
				$this->phone_number,
				$this->email,
				$this->is_admin,
				$id
			]
		);
		return $query;
	}
}
