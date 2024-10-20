<?php

namespace App\Api\Modules\Collaborator\Entity;

use App\Api\Modules\Collaborator\Dtos\CollaboratorDto;
use App\Api\Shared\Database\Connection;
use stdClass;

class CollaboratorEntity
{

	public function __construct(
		private readonly Connection $connection = new Connection()
	) {}

	public function create(CollaboratorDto $collaboratorDto)
	{
		return $this->connection->query(
			"INSERT INTO collaborators (name, CPF, phone_number, email, is_admin) VALUES (:name, :cpf, :phone_number, :email, :is_admin)",
			[
				...(array) $collaboratorDto,
				'is_admin' => (int) $collaboratorDto->is_admin
			]
		);
	}

	public function selectAll()
	{
		return $this->connection->query("SELECT id, name, email, phone_number, CPF, is_admin FROM collaborators");
	}

	/** @return CollaboratorDto */
	public function selectById(int $id)
	{
		$collaborator = $this->connection->query("SELECT id, name, email, phone_number, CPF, is_admin FROM collaborators WHERE id = :id", ['id' => $id]);
		return (object) $collaborator;
	}

	/** @return CollaboratorDto */
	public function selectByEmail(string $email)
	{
		$collaborator = $this->connection->query("SELECT id, name, email, password, is_admin from collaborators WHERE email = :email", ['email' => $email]);
		if (count($collaborator) === 0) return null;

		return (object) $collaborator[0];
	}

	public function delete(int $id)
	{
		return $this->connection->query("DELETE FROM collaborators WHERE id = :id", ['id' => $id]);
	}

	public function update(int $id, CollaboratorDto $collaboratorDto)
	{
		return $this->connection->query(
			"UPDATE collaborators SET name = :name, CPF = :cpf, phone_number = :phone_number, email = :email, is_admin = :is_admin WHERE id = :id",
			[
				...(array) $collaboratorDto,
				'is_admin' => (int) $collaboratorDto->is_admin,
				'id' => $id
			]
		);
	}

	public function updatePassword(int $id, string $newPassword)
	{
		return $this->connection->query(
			"UPDATE collaborators SET password = :password WHERE id = :id",
			[
				'id' => $id,
				'password' => $newPassword
			]
		);
	}
}
