<?php

namespace App\Api\Shared\Services\Cep\Dtos;

class AddressDto
{
	public function __construct(
		public string $cep,
		public string $neighborhood,
		public string $city,
		public string $uf,
	) {}
}
