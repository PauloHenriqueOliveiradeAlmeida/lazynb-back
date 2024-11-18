<?php

namespace App\Api\Modules\Auth\Dtos;

use Raven\Cassowary\Validators\IsEmail;
use Raven\Cassowary\Validators\IsRequired;
use Raven\Cassowary\Validators\IsString;
use Raven\Cassowary\Validators\Length;

class FirstAccessDto
{
	#[IsRequired]
	#[IsString]
	#[Length(min: 6, max: 6, message: 'O código de verificação deve ter 6 caracteres')]
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
