<?php

require_once __DIR__ . "/../../shared/packages/http-response/http-response.php";
require_once __DIR__ . "/../../shared/auth/auth.service.php";
require_once "database/amenity.model.php";

class AmenityController
{
	public static function processAmenities($data)
	{
		$propertyId = $data['propertyId'];
		$amenities = $data['amenities'];

		try {
			foreach ($amenities as $amenity) {
				$amenityName = $amenity['amenity'];

				$amenityRecord = Amenity::findByName($amenityName);

				if ($amenityRecord) {
					$amenityId = $amenityRecord['id'];
				} else {
					$amenityModel = new Amenity($amenityName);
					$amenityModel->create();
					$amenityId = Amenity::getLastInsertId();
				}
				Amenity::addAmenityToProperty($propertyId, $amenityId);
			}
			HttpResponse::send(HttpResponse::CREATED);
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["error" => $e->getMessage()], HttpResponse::SERVER_ERROR);
		}
	}
}
