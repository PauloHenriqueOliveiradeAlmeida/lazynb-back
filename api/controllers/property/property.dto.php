<?php
require_once __DIR__ . '/../../packages/dto/dto.base.php';
require_once __DIR__ . "/../../packages/validator/string.validator.php";
require_once __DIR__ . "/../../packages/validator/boolean.validator.php";

class PropertyDTO extends DTO {

	public static function validate(string $name, string $CEP, string $neighborhood, string $number, string $complement, string $city, string $UF, string $description) {
		$name = StringValidator::set($name)->isRequired()->get();
		$CEP = StringValidator::set($CEP)->isRequired()->get();
		$neighborhood = StringValidator::set($neighborhood)->isRequired()->get();
		$number = StringValidator::set($number)->isRequired()->get();
		$complement = StringValidator::set($complement)->isRequired()->get();
		$city = StringValidator::set($city)->isRequired()->get();
		$UF = StringValidator::set($UF)->isRequired()->get();
		$description = StringValidator::set($description)->isRequired()->get();
		return self::get(self::class, func_get_args());
	}

}
