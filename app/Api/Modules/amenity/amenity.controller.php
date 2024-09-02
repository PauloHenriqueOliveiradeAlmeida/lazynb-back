<?php

require_once __DIR__ . "/../../../shared/packages/http-response/http-response.php";
require_once __DIR__ . "/../../../shared/auth/auth.service.php";
require_once "database/amenity.model.php";

class AmenityController
{
	public static function getAll() {
		try {
			$amenities = new Amenity();
			HttpResponse::sendBody($amenities->selectAll());
		}
		catch (mysqli_sql_exception $error) {
			HttpResponse::sendBody([
				"message" => $error->getMessage()
			], HttpResponse::SERVER_ERROR);
		}
	}

	public static function getByPropertyId(int $property_id) {
		try {
			$amenities = new Amenity();
			HttpResponse::sendBody($amenities->selectByPropertyId($property_id));
		}
		catch (mysqli_sql_exception $error) {
			HttpResponse::sendBody([
				"message" => $error->getMessage()
			], HttpResponse::SERVER_ERROR);
		}
	}

	public static function connectAmenity($data)
	{
		$property_id = $data['property_id'];
		$amenities = $data['amenities'];

		try {
			foreach ($amenities as $amenity) {
				Amenity::addAmenityToProperty($property_id, $amenity);
			}
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["error" => $e->getMessage()], HttpResponse::SERVER_ERROR);
		}
	}
}
