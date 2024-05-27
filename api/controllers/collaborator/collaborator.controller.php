<?php
require_once __DIR__ . "/../../packages/http-response/http-response.php";
require_once __DIR__ . "/../../utils/generate-random-password.php";
require_once __DIR__ . "/../../models/collaborator.model.php";
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

			HttpResponse::send(HttpResponse::CREATED);
		} catch (PDOException $e) {
			switch ($e->getCode()) {
				case 1062:
					HttpResponse::send(HttpResponse::CONFLICT);
			}
		}
	}

	public static function getAll()
	{
		try {
			$collaborator = new Collaborator();

			echo json_encode($collaborator->selectAll());
		} catch (PDOException $e) {
			HttpResponse::sendBody(["error" => $e], HttpResponse::SERVER_ERROR);
		}
	}
	public static function getById($id)
	{
		try {
			$collaborator = new Collaborator();
			HttpResponse::sendBody($collaborator->selectById($id));
		} catch (PDOException $e) {
			HttpResponse::sendBody(["error" => $e], HttpResponse::SERVER_ERROR);
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

			HttpResponse::send();
		} catch (PDOException $e) {
			switch ($e->getCode()) {
				case 1062:
					HttpResponse::send(HttpResponse::CONFLICT);
				case 1049:
					HttpResponse::send(HttpResponse::NOT_FOUND);
			}
		}
	}

	public static function patch($id, array $data)
	{
		try {
			$dto = CollaboratorDTO::validate(...$data);
			$collaborator = new Collaborator(...$dto);

			$collaborator->patch($id);

			HttpResponse::send();
		} catch (PDOException $e) {
			switch ($e->getCode()) {
				case 1062:
					HttpResponse::send(HttpResponse::CONFLICT);
				case 1049:
					HttpResponse::send(HttpResponse::NOT_FOUND);
			}
		}
	}

	public static function delete($id)
	{
		try {
			$collaborator = new Collaborator();
			$collaborator->delete($id);

			HttpResponse::send();
		} catch (PDOException $e) {
			switch ($e->getCode()) {
				case 1329:
					HttpResponse::send(HttpResponse::NOT_FOUND);
				case 1049:
					HttpResponse::send(HttpResponse::NOT_FOUND);
			}
		}
	}
}
