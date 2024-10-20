<?php
require_once __DIR__ . '/../../../../shared/packages/dto/dto.base.php';
require_once __DIR__ . "/../../../../shared/packages/validator/string.validator.php";
require_once __DIR__ . "/../../../../shared/packages/validator/integer.validator.php";

class PropertyDTO extends DTO {

	public static function validate(string $name, string $CEP, string $neighborhood, string $address_number, string $complement, string $city, string $UF, string $description, int $client_id) {
		$name = StringValidator::set($name)->isRequired()->get();
		$CEP = StringValidator::set($CEP)->isRequired()->get();
		$neighborhood = StringValidator::set($neighborhood)->isRequired()->get();
		$address_number = StringValidator::set($address_number)->isRequired()->get();
		$complement = StringValidator::set($complement)->isRequired()->get();
		$city = StringValidator::set($city)->isRequired()->get();
		$UF = StringValidator::set($UF)->isRequired()->get();
		$description = StringValidator::set($description)->isRequired()->get();
		$client_id = IntegerValidator::set($client_id)->isRequired()->get();
		return self::get(self::class, func_get_args());
	}

}
