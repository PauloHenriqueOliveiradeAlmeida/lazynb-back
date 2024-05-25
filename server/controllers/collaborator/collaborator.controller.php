<?php
require_once __DIR__ . "/../../utils/generate-random-password.php";
require_once __DIR__ . "/../../models/database/collaborator.model.php";
require_once "collaborator.dto.php";

class CollaboratorController
{
	public static function create(array $data)
	{
		try {
			$dto = CollaboratorDTO::validate(...$data);
			$password = password_hash(RandomPassword::generate(), PASSWORD_DEFAULT, [
				'cost' => 15
			]);
			$collaborator = new Collaborator(...$dto, password: $password);
			$collaborator->create();

			header("location: ../../visualizar-colaboradores.html?status=201");
		} catch (mysqli_sql_exception $e) {
			switch ($e->getCode()) {
				case 1062:
					header("location: ../../visualizar-colaboradores.html?status=409");
					break;
			}
		}
	}

	public static function getAll()
	{
		$collaborator = new Collaborator();

		return $collaborator->selectAll();
	}
}
