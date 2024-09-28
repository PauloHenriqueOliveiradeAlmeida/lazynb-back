<?php

namespace App\Api\Shared\Guards\Dtos;

use Raven\Cassowary\Validators\IsBoolean;
use Raven\Cassowary\Validators\IsInteger;
use Raven\Cassowary\Validators\IsRequired;

class TokenPayloadDto
{
	#[IsInteger]
	#[IsRequired]
	public int $id;

	#[IsBoolean]
	#[IsRequired]
	public bool $is_admin;
}
