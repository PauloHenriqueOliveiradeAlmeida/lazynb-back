<?php

namespace App\Api\Shared\Decorators\Validators;

use Attribute;
use Raven\Cassowary\Validators\IValidator;
use Raven\Falcon\Http\Exceptions\BadRequestException;

#[Attribute]
class IsCPF implements IValidator
{
	public function __construct(
		private readonly ?string $message = null
	) {}

	public function validate(string $propertyName, $value): bool
	{
		$cpf = preg_replace('/[^0-9]/', '', $value);

		if (strlen($cpf) != 11) {
			throw new BadRequestException($this->message ?? "$propertyName is not a valid CPF, $propertyName length is not 11 characters");
		}

		if (preg_match('/(\d)\1{10}/', $cpf)) {
			throw new BadRequestException($this->message ?? "$propertyName is not a valid CPF, $propertyName length is a same repeated numbers");
		}

		for ($t = 9; $t < 11; $t++) {
			$sum = 0;
			for ($i = 0; $i < $t; $i++) {
				$sum += $cpf[$i] * (($t + 1) - $i);
			}
			$digit = ((10 * $sum) % 11) % 10;
			if ($cpf[$t] != $digit) {
				throw new BadRequestException($this->message ?? "$propertyName is not a valid CPF, $propertyName has invalid digits");
			}
		}

		return true;
	}
}
