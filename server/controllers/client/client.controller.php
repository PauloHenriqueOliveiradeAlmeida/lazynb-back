<?php
require_once __DIR__ . "/../../utils/generate-random-password.php";
require_once __DIR__ . "/../../models/database/client.model.php";
require_once __DIR__ . "/../../models/update-manager/update-manager.model.php";
require_once "client.dto.php";

class ClientController
{
	public static function create(array $data)
	{
		try {
			$dto = ClientDTO::validate(...$data);
			$client = new Client(...$dto);
			$client->create();
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
		try {
			$client = new Client();
			echo json_encode($client->selectAll());
		} catch (mysqli_sql_exception $e) {
			throw $e;
		}
	}

	public static function getById($id)
	{
		try {
			$client = new Client();
			echo json_encode($client->selectById($id));
		} catch (mysqli_sql_exception $e) {
			throw $e;
		}
	}

	public static function update($id, array $data)
	{
		try {
			$dto = ClientDTO::validate(...$data);

			$old_data = Client::selectById($id)[0];
			$reflected_dto = UpdateManager::updateValuesFrom($old_data, $dto);
			$client = new Client(...$reflected_dto);
			$client->update($id);

			header("location: ../../visualizar-colaboradores.php?status=201");
		} catch (mysqli_sql_exception $e) {
			return ($e->getCode());
		}
	}

	public static function delete($id)
	{
		try {
			$client = new Client();
			$client->delete($id);

			header("location: ../../visualizar-colaboradores.php?status=201");
		} catch (mysqli_sql_exception $e) {
			return ($e->getCode());
		}
	}
}
