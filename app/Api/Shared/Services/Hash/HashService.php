<?php

namespace App\Api\Shared\Services\Hash;

class HashService
{
	public function hash(string $password)
	{
		return password_hash($password, PASSWORD_DEFAULT, [
			'cost' => getenv("HASH_PASSWORD_COST")
		]);
	}

	public function verify(string $password, string $hashedPassword)
	{
		return password_verify($password, $hashedPassword);
	}
}
