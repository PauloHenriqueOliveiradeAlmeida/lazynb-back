<?php

require_once __DIR__ . "/../../packages/http-response/http-response.php";
require_once __DIR__ . "/../../models/property.model.php";
require_once "property.dto.php";

class PropertyController
{
	public static function create(array $data, $id)
	{
		try {
			$dto = PropertyDTO::validate(...$data);
			$property = new Property(...$dto);
			$property->create($id);

			HttpResponse::send(HttpResponse::CREATED);
		} catch (mysqli_sql_exception $e) {
			switch ($e->getCode()) {
				case 1062:
					HttpResponse::send(HttpResponse::CONFLICT);
			}
		}
	}
}
