<?php
require_once __DIR__ . '/../../models/dto/dto.base.php';
require_once __DIR__ . "/../../models/validator/string.validator.php";
require_once __DIR__ . "/../../models/validator/boolean.validator.php";

class ClientDTO extends DTO {

	public static function validate(string $name, string $CPF, string $email, string $phone_number) {
		$name = StringValidator::set($name)->isRequired()->get();
		$CPF = StringValidator::set($CPF)->isRequired()->get();
		$email = StringValidator::set($email)->isRequired()->isEmail()->get();
		$phone_number = StringValidator::set($phone_number)->isRequired()->get();
		return self::get(self::class, args: func_get_args());
	}
}
