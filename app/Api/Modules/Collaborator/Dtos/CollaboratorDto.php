<?php

namespace App\Api\Modules\Collaborator\Dtos;

use App\Api\Shared\Decorators\Validators\IsCPF;
use Raven\Cassowary\Validators\IsBoolean;
use Raven\Cassowary\Validators\IsEmail;
use Raven\Cassowary\Validators\IsInteger;
use Raven\Cassowary\Validators\IsRequired;
use Raven\Cassowary\Validators\IsString;
use Raven\Cassowary\Validators\Length;

class CollaboratorDto
{
	#[IsInteger]
	public ?int $id;

	#[IsRequired]
	#[IsString]
	#[Length(min: 3, max: 100)]
	public string $name;

	#[IsRequired]
	#[IsString]
	#[IsCPF]
	public string $cpf;

	#[IsRequired]
	#[IsString]
	#[IsEmail]
	#[Length(min: 3, max: 150)]
	public string $email;

	#[IsRequired]
	#[IsString]
	#[Length(min: 10, max: 11)]
	public string $phone_number;

	#[IsRequired]
	#[IsBoolean]
	public bool $is_admin;

	#[IsString]
	public ?string $password;
}
