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
		} catch (PDOException $e) {
			switch ($e->getCode()) {
				case 1062:
					header("location: ../../cadastrar-colaborador.html?status=409");
					break;
				case 1049:
					header("location: ../../cadastrar-colaborador.html?status=404");
					break;
			}
		}
	}

	public static function selectAll()
	{
		try {
			$collaborator = new Collaborator();

			echo json_encode($collaborator->selectAll());

		} catch (PDOException $e) {
			switch ($e->getCode()) {
				case 1049:
					header("location: ../../visualizar-colaboradores.html?status=404");
					break;
			}
		}
	}
	public static function selectById($id)
	{
		try {
			$collaborator = new Collaborator();
			echo json_encode($collaborator->selectById($id));

		} catch (PDOException $e) {
			switch ($e->getCode()) {
				case 1049:
					header("location: ../../visualizar-colaboradores.html?status=404");
					break;
			}
		}
	}

	public static function update($id, array $data)
	{
		try {
			$dto = CollaboratorDTO::validate(...array_diff_key($data, ['password' => '']));
			$password = password_hash($data['password'], PASSWORD_DEFAULT, [
				'cost' => 15
			]);
			$collaborator = new Collaborator(...$dto, password: $password);
			$collaborator->update($id);

			header("location: ../../visualizar-colaboradores.php?status=201");
		} catch (PDOException $e) {
			switch ($e->getCode()) {
				case 1062:
					header("location: ../../editar-colaborador.html?status=409");
					break;
				case 1049:
					header("location: ../../editar-colaborador.html?status=404");
					break;
			}
		}
	}

	public static function patch($id, array $data)
	{
		try {
			$dto = CollaboratorDTO::validate(...$data);
			$collaborator = new Collaborator(...$dto);

			$collaborator->patch($id);

			header("location: ../../visualizar-colaboradores.html?status=201");
		} catch (PDOException $e) {
			switch ($e->getCode()) {
				case 1062:
					header("location: ../../editar-colaborador.html?status=409");
					break;
				case 1049:
					header("location: ../../editar-colaborador.html?status=404");
					break;
			}
		}
	}

	public static function delete($id)
	{
		try {
			$collaborator = new Collaborator();
			return $collaborator->delete($id);

		} catch (PDOException $e) {
			switch ($e->getCode()) {
				case 1329:
					header("location: ../../deletar-colaborador.html?status=404");
				case 1049:
					header("location: ../../deletar-colaborador.html?status=404");
					break;
			}
		}
	}
}
