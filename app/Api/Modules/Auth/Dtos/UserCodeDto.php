<?php

namespace App\Api\Modules\Auth\Dtos;

use Raven\Cassowary\Validators\IsInteger;
use Raven\Cassowary\Validators\IsString;
use Raven\Cassowary\Validators\Length;

class UserCodeDto
{
	#[IsInteger]
	public ?int $id;

	#[IsString]
	#[Length(max: 8)]
	public string $verification_code;

	#[IsInteger]
	public int $user_id;
}
