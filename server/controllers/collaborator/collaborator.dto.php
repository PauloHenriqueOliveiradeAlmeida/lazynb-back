<?php

require_once __DIR__ . "/../../models/validator/string.validator.php";
require_once __DIR__ . "/../../models/validator/boolean.validator.php";

class CollaboratorDTO {

	private readonly string $name;
	private readonly string $CPF;
	private readonly string $email;
	private readonly string $phone_number;

	public function __construct(string $name, string $CPF, string $email, string $phone_number, bool $is_admin) {
		$v_name = new StringValidator($name);
		$v_CPF = new StringValidator($CPF);
		$v_email = new StringValidator($email);
		$v_phone_number = new StringValidator($phone_number);

		$this->name = $v_name->isRequired()->get();
		$this->CPF = $v_CPF->isRequired()->get();
		$this->email = $v_email->isRequired()->isEmail()->get();
		$this->phone_number = $v_phone_number->isRequired()->get();
	}

	public function get() {
		return [
			$this->name,
			$this->CPF,
			$this->email,
			$this->phone_number
		];
	}

}
