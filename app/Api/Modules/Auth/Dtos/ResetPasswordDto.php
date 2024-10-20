<?php

namespace App\Api\Modules\Auth\Dtos;

use Raven\Cassowary\Validators\IsEmail;
use Raven\Cassowary\Validators\IsRequired;
use Raven\Cassowary\Validators\IsString;
use Raven\Cassowary\Validators\Length;

class ResetPasswordDto
{
	#[IsRequired]
	#[IsString]
	#[Length(min: 8, max: 8)]
	public string $verificationCode;


	#[IsRequired]
	#[IsString]
	#[Length(min: 3, max: 150)]
	#[IsEmail]
	public string $email;

	#[IsRequired]
	#[IsString]
	#[Length(min: 8, max: 150)]
	public string $password;

	#[IsRequired]
	#[IsString]
	#[Length(min: 8, max: 150)]
	public string $confirmPassword;
}
