<?php

namespace App\Api\Modules\Auth\Dtos;

use Raven\Cassowary\Validators\IsEmail;
use Raven\Cassowary\Validators\IsRequired;
use Raven\Cassowary\Validators\IsString;
use Raven\Cassowary\Validators\Length;

class VerifyResetPasswordCodeDto
{
	#[IsRequired]
	#[IsString]
	#[Length(min: 3, max: 150, message: 'O nome deve ter entre 3 e 150 caracteres')]
	#[IsEmail]
	public string $email;

	#[IsRequired]
	#[IsString]
	#[Length(min: 6, max: 6, message: 'O código de verificação deve ter 6 caracteres')]
	public string $verificationCode;
}
