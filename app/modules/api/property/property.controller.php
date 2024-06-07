<?php

require_once __DIR__ . "/../../../shared/packages/update-manager/update-manager.php";
require_once __DIR__ . "/../../../shared/packages/http-response/http-response.php";
require_once __DIR__ . "/../../../shared/auth/auth.service.php";
require_once __DIR__ . "/../amenity/amenity.controller.php";
require_once __DIR__ . "/../amenity/database/amenity.model.php";
require_once "database/property.model.php";
require_once "dtos/property.dto.php";

class PropertyController
{
    public static function create(array $data)
    {
        try {
			$amenities = $data['amenities'];
			unset($data['amenities']);
            $dto = PropertyDTO::validate(...$data);
            $property = new Property(...$dto);
            $property->create();

			AmenityController::connectAmenity([
				'property_id' => $property->id,
				'amenities' => $amenities

			]);

            HttpResponse::sendBody([
				"message" => "Propriedade criada com sucesso"
			], HttpResponse::CREATED);
        } catch (mysqli_sql_exception $e) {
            switch ($e->getCode()) {
                case 1062:
                    HttpResponse::send(HttpResponse::CONFLICT);
                    break;
                default:
                    HttpResponse::sendBody(["error" => $e->getMessage()], HttpResponse::SERVER_ERROR);
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
				$amenity = new Amenity();
				$amenities = $amenity->selectByPropertyId($id);
                HttpResponse::sendBody([...$result, "amenities" => $amenities]);
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

    public static function update(int $id, array $data)
    {
        try {
			$old_data = Property::selectById($id);
			$amenities = $data['amenities'];
			unset($data['amenities']);
            $dto = PropertyDTO::validate(...$data);
            $property = new Property(...$dto);
            $property->update($id);

			$amenity = new Amenity();
			$registered_amenities = $amenity->selectByPropertyId($old_data["id"]);

			$intermediary_for_delete = array_filter($registered_amenities, function ($a) use($amenities) {
				return !in_array(strval($a["amenityId"]), $amenities) && $a;
			});
			$intermediary_for_create = array_filter($amenities, function ($a) use($registered_amenities) {
				return !in_array($a, array_map(function ($registered_amenity) {
					return $registered_amenity["amenityId"];
				}, $registered_amenities)) && $a;
			});
			$amenity->deleteMany(array_map(function ($amenity) {
				return $amenity["propertyId"];
			}, $intermediary_for_delete));

			AmenityController::connectAmenity([
				'property_id' => $old_data["id"],
				'amenities' => $intermediary_for_create

			]);

            HttpResponse::sendBody([
				"message" => "Propriedade editada com sucesso"
			]);
        } catch (mysqli_sql_exception $e) {
            HttpResponse::sendBody(["error" => $e->getMessage()], HttpResponse::SERVER_ERROR);
        }
    }

    public static function delete($id)
    {
        try {
            $property = new Property();
            $property->delete($id);

            HttpResponse::sendBody([
				"message" => "Propriedade deletada com sucesso"
			]);
        } catch (mysqli_sql_exception $e) {
            HttpResponse::sendBody(["error" => $e->getMessage()], HttpResponse::SERVER_ERROR);
        }
    }

}
?>
