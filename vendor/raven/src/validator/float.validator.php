<?php

require_once "validator.base.php";

class FloatValidator extends Validator {

	public function __construct(float $data) {
		$this->data = $data;
	}

	public static function set(string $data) {
		return new static($data);
	}

}
