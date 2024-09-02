<?php

namespace App\Api\Modules\Client;

use App\Api\Modules\Client\Entity\ClientEntity;
use mysqli_sql_exception;
use Raven\Falcon\Http\Response;
use Raven\Falcon\Http\StatusCode;

// require_once "client.dto.php";

class ClientService
{
	// public static function create(array $data)
	// {
	// 	try {
	// 		$dto = ClientDTO::validate(...$data);
	// 		$client = new Client(...$dto);
	// 		$client->create();

	// 		return Response::sendBody([
	// 			"message" => "Cliente criado com sucesso"
	// 		], StatusCode::CREATED);

	// 	} catch (mysqli_sql_exception $e) {
	// 		switch ($e->getCode()) {
	// 			case 1062:
	// 				return Response::sendBody([
	// 					"message" => "CPF ou email já cadastrados, tente com outros dados"
	// 				], StatusCode::CONFLICT);
	// 		}
	// 	}
	// }

	public static function getAll()
	{
		try {
			$client = new ClientEntity();
			Response::sendBody($client->selectAll());
		} catch (mysqli_sql_exception $e) {
			Response::sendBody(["error" => $e], StatusCode::SERVER_ERROR);
		}
	}

	// public static function getById($id)
	// {
	// 	try {
	// 		$client = new ClientEntity();
	// 		Response::sendBody($client->selectById($id));
	// 	} catch (mysqli_sql_exception $e) {
	// 		Response::sendBody(["error" => $e], StatusCode::SERVER_ERROR);
	// 	}
	// }

	// public static function update($id, array $data)
	// {
	// 	try {
	// 		$dto = ClientDTO::validate(...$data);

	// 		$old_data = Client::selectById($id);
	// 		// $reflected_dto = UpdateManager::updateValuesFrom($old_data, $dto);
	// 		$client = new Client(...$dto);
	// 		$client->update($id);

	// 		Response::sendBody([
	// 			"message" => "Cliente atualizado com sucesso"
	// 		]);
	// 	} catch (mysqli_sql_exception $e) {
	// 		Response::sendBody(["message" => $e], StatusCode::SERVER_ERROR);
	// 	}
	// }

	// public static function delete($id)
	// {
	// 	try {
	// 		$client = new Client();
	// 		$client->delete($id);

	// 		Response::sendBody([
	// 			"message" => "Cliente excluído com sucesso"
	// 		]);
	// 	} catch (mysqli_sql_exception $e) {
	// 		Response::sendBody(["message" => $e], StatusCode::SERVER_ERROR);
	// 	}
	// }
}
