<?php
require_once __DIR__ . '/../../shared/packages/dto/dto.base.php';
require_once __DIR__ . "/../../shared/packages/validator/string.validator.php";
require_once __DIR__ . "/../../shared/packages/validator/boolean.validator.php";

class CollaboratorDTO extends DTO {

	public static function validate(string $name, string $CPF, string $email, string $phone_number, bool $is_admin) {
		$name = StringValidator::set($name)->isRequired()->get();
		$CPF = StringValidator::set($CPF)->isRequired()->get();
		$email = StringValidator::set($email)->isRequired()->isEmail()->get();
		$phone_number = StringValidator::set($phone_number)->isRequired()->get();
		$is_admin = BooleanValidator::set($is_admin)->isRequired()->get();
		return self::get(self::class, func_get_args());
	}

}
