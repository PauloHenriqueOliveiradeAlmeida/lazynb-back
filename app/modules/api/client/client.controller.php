<?php

require_once __DIR__ . "/../../../shared/interfaces/IController.interface.php";
require_once __DIR__ . "/../../../shared/packages/update-manager/update-manager.php";
require_once __DIR__ . "/../../../shared/packages/http-response/http-response.php";
require_once "database/client.model.php";
require_once "client.dto.php";

class ClientController implements IController
{
	public static function create(array $data)
	{
		try {
			$dto = ClientDTO::validate(...$data);
			$client = new Client(...$dto);
			$client->create();

			HttpResponse::sendBody([
				"message" => "Cliente criado com sucesso"
			], HttpResponse::CREATED);
		} catch (mysqli_sql_exception $e) {
			switch ($e->getCode()) {
				case 1062:
					HttpResponse::sendBody([
						"message" => "CPF ou email já cadastrados, tente com outros dados"
					], HttpResponse::CONFLICT);
			}
		}
	}

	public static function getAll()
	{
		try {
			$client = new Client();
			HttpResponse::sendBody($client->selectAll());
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["error" => $e], HttpResponse::SERVER_ERROR);
		}
	}

	public static function getById($id)
	{
		try {
			$client = new Client();
			HttpResponse::sendBody($client->selectById($id));
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["error" => $e], HttpResponse::SERVER_ERROR);
		}
	}

	public static function update($id, array $data)
	{
		try {
			$dto = ClientDTO::validate(...$data);

			$old_data = Client::selectById($id);
			$reflected_dto = UpdateManager::updateValuesFrom($old_data, $dto);
			$client = new Client(...$reflected_dto);
			$client->update($id);

			HttpResponse::sendBody([
				"message" => "Cliente atualizado com sucesso"
			]);
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["message" => $e], HttpResponse::SERVER_ERROR);
		}
	}

	public static function delete($id)
	{
		try {
			$client = new Client();
			$client->delete($id);

			HttpResponse::sendBody([
				"message" => "Cliente excluído com sucesso"
			]);
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["message" => $e], HttpResponse::SERVER_ERROR);
		}
	}
}
