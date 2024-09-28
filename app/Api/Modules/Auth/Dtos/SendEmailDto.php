<?php

namespace App\Api\Modules\Auth\Dtos;

use Raven\Cassowary\Validators\IsEmail;
use Raven\Cassowary\Validators\IsRequired;
use Raven\Cassowary\Validators\IsString;
use Raven\Cassowary\Validators\Length;

class SendEmailDto
{
	#[IsRequired]
	#[IsString]
	#[Length(min: 3, max: 150)]
	#[IsEmail]
	public string $email;
}
