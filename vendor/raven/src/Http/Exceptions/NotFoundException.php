<?php

namespace Raven\Http\Exceptions;

use Raven\Http\StatusCode;

class NotFoundException extends \Exception
{
	public function __construct(string $message = null, $code = StatusCode::NOT_FOUND, \Exception $previous = null)
	{
		parent::__construct($message ?? 'Not Found', $code->value, $previous);
		header('Content-Type: application/json');
	}
}
