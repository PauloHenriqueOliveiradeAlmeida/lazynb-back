<?php

require_once __DIR__ . "/../../shared/packages/http-response/http-response.php";
require_once __DIR__ . "/../../shared/auth/auth.service.php";
require_once "database/property.model.php";
require_once "dtos/property.dto.php";

class PropertyController
{
	public static function create(array $data)
	{
		try {
			$dto = PropertyDTO::validate(...$data);
			$property = new Property(...$dto);
			$property->create($data['id']);

			HttpResponse::send(HttpResponse::CREATED);
		} catch (mysqli_sql_exception $e) {
			switch ($e->getCode()) {
				case 1062:
					HttpResponse::send(HttpResponse::CONFLICT);
					break;
			}
		}
	}

	public static function getAll()
	{
		try {
			$property = new Property();
			HttpResponse::sendBody($property->selectAll());
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["error" => $e->getMessage()], HttpResponse::SERVER_ERROR);
		}
	}

	public static function getById($id)
	{
		try {
			$property = new Property();
			$result = $property->selectById($id);
			if ($result) {
				HttpResponse::sendBody($result);
			} else {
				HttpResponse::send(HttpResponse::NOT_FOUND);
			}
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["error" => $e->getMessage()], HttpResponse::SERVER_ERROR);
		}
	}

	public static function getByClientId($clientId)
	{
		try {
			echo "teste";
			$property = new Property();
			$result = $property->selectByClientId($clientId);
			if ($result) {
				HttpResponse::sendBody($result);
			} else {
				HttpResponse::send(HttpResponse::NOT_FOUND);
			}
		} catch (Exception $e) {
			HttpResponse::sendBody(["error" => $e->getMessage()], HttpResponse::SERVER_ERROR);
		}
	}

	public static function update($id, array $data)
	{
		try {
			$dto = PropertyDTO::validate(...$data);
			$property = new Property(...$dto);
			$property->update($id);

			HttpResponse::send();
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["error" => $e->getMessage()], HttpResponse::SERVER_ERROR);
		}
	}

	public static function delete($id)
	{
		try {
			$property = new Property();
			$property->delete($id);

			HttpResponse::send();
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["error" => $e->getMessage()], HttpResponse::SERVER_ERROR);
		}
	}
}
