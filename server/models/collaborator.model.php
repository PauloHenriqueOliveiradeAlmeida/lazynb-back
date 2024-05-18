<?php

require_once "database/connection.php";

class Collaborator
{
	public int $id;
	public string $name;
	public string $CPF;
	public string $phone_number;
	public string $email;
	private string $password;
	private bool $is_admin;

	public function setPermission($is_admin)
	{
		$this->is_admin = $is_admin;
	}
	public function setPassword($password)
	{
		$this->password = password_hash($password, PASSWORD_DEFAULT, ["cost" => 15]);
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
		$query = $connection->queryDB("SELECT id, name, email, phone_number, CPF FROM collaborators");
		return $query->fetch_all(MYSQLI_ASSOC);
	}
}
