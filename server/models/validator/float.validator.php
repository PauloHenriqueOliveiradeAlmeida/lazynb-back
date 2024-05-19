<?php

require_once "validator.base.php";

class FloatValidator extends Validator {

	public readonly float $data;

	public function get() {
		return $this->data;
	}

	public function isRequired(string $message = null)
	{
		if (isset($this->data)) {
			return new self($this->data);
		}
		else {
			throw new Exception($message ? $message : "{$this->data} não foi informado, mas é obrigatório", 400);
		}
	}

	public function length(?int $min = 0, ?int $max = 10, ?string $message = null) {
		$data_length = strlen(strval($this->data));

		if ($data_length >= $min && $data_length <= $max) {
			return new self($this->data);
		}
		else {
			throw new LengthException($message ? $message : "{$this->data} deve ter entre $min e $max caracteres", 400);
		}
	}

	public function __construct(float $data) {
		$this->data = $data;
	}

}
