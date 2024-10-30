<?php

namespace App\Api\Shared\Decorators\Validators;

use Attribute;
use Raven\Cassowary\Validators\IValidator;
use Raven\Falcon\Http\Exceptions\BadRequestException;

#[Attribute]
class IsArray implements IValidator
{

	/** @param 'string' | 'integer' | 'bool' | 'float'  $eachType */
	public function __construct(
		private readonly string $eachType
	) {}

	public function validate(string $propertyName, $value): bool
	{
		if (!is_array($value)) {
			throw new BadRequestException("$propertyName is not an array");
		}

		$incorrectTypes = array_filter($value, fn($v) => gettype($v) !== $this->eachType);
		if (count($incorrectTypes) > 0) throw new BadRequestException("$propertyName has a incorrect types");

		return true;
	}
}
