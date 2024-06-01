<?php
require_once __DIR__ . "/../../shared/packages/http-response/http-response.php";
require_once __DIR__ . "/../../shared/utils/random-password/random-password.php";
require_once __DIR__ . "/../../shared/auth/auth.service.php";
require_once "database/collaborator.model.php";
require_once "dtos/login.dto.php";
require_once "dtos/collaborator.dto.php";

class CollaboratorController
{
	public static function create(array $data)
	{
		try {
			$dto = CollaboratorDTO::validate(...$data);
			$random_password = RandomPassword::generate();
			$password = password_hash($random_password, PASSWORD_DEFAULT, [
				'cost' => 15
			]);
			$collaborator = new Collaborator(...$dto, password: $password);
			$collaborator->create();

			HttpResponse::sendBody(["message" => $random_password], HttpResponse::CREATED);
		} catch (mysqli_sql_exception $e) {
			switch ($e->getCode()) {
				case 1062:
					HttpResponse::sendBody([
						"message" => "O email ou cpf digitado já está cadastrado, tente novamente com outro valor"
					], HttpResponse::CONFLICT);
			}
		}
	}

	public static function getAll()
	{
		try {
			$collaborator = new Collaborator();
			HttpResponse::sendBody($collaborator->selectAll());
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["error" => $e], HttpResponse::SERVER_ERROR);
		}
	}
	public static function getById($id)
	{
		try {
			$collaborator = new Collaborator();
			HttpResponse::sendBody($collaborator->selectById($id));
		} catch (mysqli_sql_exception $e) {
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
		} catch (mysqli_sql_exception $e) {
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
		} catch (mysqli_sql_exception $e) {
			switch ($e->getCode()) {
				case 1062:
					HttpResponse::send(HttpResponse::CONFLICT);
				case 1049:
					HttpResponse::send(HttpResponse::NOT_FOUND);
				default:
					HttpResponse::sendBody(["error" => $e->getMessage()], HttpResponse::SERVER_ERROR);
			}
		}
	}

	public static function delete($id)
	{
		try {
			$collaborator = new Collaborator();
			$collaborator->delete($id);

			HttpResponse::send();
		} catch (mysqli_sql_exception $e) {
			switch ($e->getCode()) {
				case 1329:
					HttpResponse::send(HttpResponse::NOT_FOUND);
				case 1049:
					HttpResponse::send(HttpResponse::NOT_FOUND);
			}
		}
	}

	public static function login(array $data) {
		try {
			$dto = LoginDTO::validate(...$data);
			$collaborator = new Collaborator();
			$collaborator_datas = $collaborator->selectByEmail($dto['email']);

			if (count($collaborator_datas) === 0) {
				HttpResponse::sendBody([
					'message' => 'Não há nenhum registro com esse email, tente outro email'
				], HttpResponse::NOT_FOUND);
			}

			Auth::login($collaborator_datas, $data['password']);

			HttpResponse::send();
		}
		catch(mysqli_sql_exception $error) {
			HttpResponse::sendBody(["message" => $error->getMessage()], HttpResponse::SERVER_ERROR);
		}
	}

	public static function logout() {
		echo "la";
		Auth::logout();
		HttpResponse::send(HttpResponse::NO_CONTENT);
	}
}
