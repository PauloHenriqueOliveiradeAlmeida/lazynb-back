<?php

namespace App\Api\Modules\Collaborator\Entity;

use App\Api\Modules\Collaborator\Dtos\CollaboratorDto;
use App\Api\Shared\Database\Connection;

class CollaboratorEntity
{

	public function __construct(
		private readonly Connection $connection = new Connection()
	) {}

	public function create(CollaboratorDto $collaboratorDto)
	{
		return $this->connection->query(
			"INSERT INTO collaborators (name, CPF, phone_number, email, is_admin, password) VALUES (:name, :cpf, :phone_number, :email, :is_admin, :password)",
			...(array) $collaboratorDto
		);
	}

	public function selectAll()
	{
		return $this->connection->query("SELECT id, name, email, phone_number, CPF, is_admin FROM collaborators");
	}

	public function selectById(int $id)
	{
		return $this->connection->query("SELECT id, name, email, phone_number, CPF, is_admin FROM collaborators WHERE id = :id", ['id' => $id]);
	}

	public function selectByEmail(string $email)
	{
		return $this->connection->query("SELECT id, name, email, password, is_admin from collaborators WHERE email = :email", ['email' => $email]);
	}

	public function delete(int $id)
	{
		return $this->connection->query("DELETE FROM collaborators WHERE id = :id", ['id' => $id]);
	}

	public function update(int $id, CollaboratorDto $collaboratorDto)
	{
		return $this->connection->query(
			"UPDATE collaborators SET name = :name, CPF = :cpf, phone_number = :phone_number, email = :email, password = :password, is_admin = :is_admin WHERE id = :id",
			[
				...(array) $collaboratorDto,
				'id' => $id
			]
		);
	}
}
