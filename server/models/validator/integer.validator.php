<?php

require_once "validator.base.php";

class IntegerValidator extends Validator {

	public function __construct(int $data) {
		$this->data = $data;
	}

	public static function set(string $data) {
		return new static($data);
	}

}
