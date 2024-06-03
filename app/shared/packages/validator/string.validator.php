<?php

require_once "validator.base.php";

class StringValidator extends Validator {

	public function __construct(string $data) {
		$this->data = $data;
	}

	public static function set(string $data) {
		return new static($data);
	}

	public function isEmail(?string $message = null) {
		if (filter_var($this->data, FILTER_VALIDATE_EMAIL)) {
			return new self($this->data);
		}
		else {
			throw new Exception($message ? $message : "{$this->data} deve ser um email válido", 400);
		}
	}
}
