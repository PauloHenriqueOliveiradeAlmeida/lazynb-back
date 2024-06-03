<?php

require_once __DIR__ . "/../../../../shared/packages/dto/dto.base.php";
require_once __DIR__ . "/../../../../shared/packages/validator/string.validator.php";

class LoginDTO extends DTO {
	public static function validate(string $email, string $password) {
		$email = StringValidator::set($email)->isRequired()->isEmail()->get();
		$password = StringValidator::set($password)->get();
		return self::get(LoginDTO::class, args: func_get_args());
	}
}
