<?php

namespace App\Api\Shared\Services\Cep;

use App\Api\Shared\Services\Cep\Dtos\AddressDto;

interface ICep
{
	public function getAddress(string $cep): AddressDto;
}
