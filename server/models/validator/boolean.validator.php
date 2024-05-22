<?php

require_once "validator.base.php";

class BooleanValidator extends Validator {

	public function __construct(bool $data) {
		$this->data = $data;
	}

	public static function set(string $data) {
		return new static($data);
	}

}
