<?php

namespace App\Api\Shared\Filters\DatabaseOperation;

use PDOException;
use Raven\Falcon\Http\Exceptions\BadRequestException;
use Raven\Falcon\Http\Exceptions\ConflictException;

class DatabaseOperationFilter
{
	public function handle(PDOException $exception)
	{
		$field_name = [];
		preg_match("/\(([^)]+)\)=/", $exception->getMessage(), $field_name);

		if (empty($field_name)) {
			throw new BadRequestException($exception->getMessage());
		}

		throw new ConflictException("{$field_name[1]} já existe");
	}
}
