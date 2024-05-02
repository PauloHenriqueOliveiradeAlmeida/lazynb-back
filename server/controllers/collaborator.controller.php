<?php

require_once __DIR__ . "/../models/collaborator.model.php";
require_once __DIR__ . "/../utils/requestIsEmpty.php";
require_once __DIR__ . "/../utils/generate-random-password.php";

class CollaboratorController
{
	public static function create(array $data)
	{
		try {
			$collaborator = new Collaborator();

			$collaborator->name = $data['name'];
			$collaborator->CPF = $data['CPF'];
			$collaborator->email = $data['email'];
			$collaborator->phone_number = $data['phone_number'];
			$collaborator->setPermission($data['is_admin']);
			$collaborator->setPassword("");

			$collaborator->create();

			header("location: ../../cadastrar-colaborador.html?sucess=true");
		} catch (mysqli_sql_exception $e) {
			switch ($e->getCode()) {
				case 1062:
					header("location: ../../cadastrar-colaborador.html?error=409");
					break;
			}
		}
	}

	public static function getAll() {
		$collaborator = new Collaborator();

		return $collaborator->selectAll();
	}
}
