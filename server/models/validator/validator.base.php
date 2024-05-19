<?php

require_once "validator.base.php";

abstract class Validator {

	abstract public function get();

	abstract public function isRequired(string $message = null);

	abstract public function length(?int $min = 0, ?int $max = 10, ?string $message = null);
}
