<?php

namespace App\Api\Shared\Services\Cep;

use App\Api\Shared\Services\Cep\Dtos\AddressDto;

class CepService
{
	public function __construct(private readonly ICep $cepGateway) {}

	public function getAddress(string $cep): AddressDto
	{
		return $this->cepGateway->getAddress($cep);
	}
}
