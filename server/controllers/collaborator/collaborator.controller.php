<?php

require_once __DIR__ . "/../../models/database/collaborator.model.php";
require_once "collaborator.dto.php";
require_once __DIR__ . "/../../utils/request-is-empty.php";
require_once __DIR__ . "/../../utils/generate-random-password.php";

class CollaboratorController
{
	public static function create(array $data)
	{
		try {
			$dto = new CollaboratorDTO(...$data);
			$dto = $dto->get();
			$collaborator = new Collaborator(...$dto);
			$collaborator->setPassword("");
			$collaborator->setPermission(true);
			$collaborator->create();

			header("location: ../../visualizar-colaboradores.php?status=201");
		} catch (mysqli_sql_exception $e) {
			switch ($e->getCode()) {
				case 1062:
					header("location: ../../visualizar-colaboradores.php?status=409");
					break;
			}
		}
	}

	public static function getAll() {
		$collaborator = new Collaborator();

		return $collaborator->selectAll();
	}
}
