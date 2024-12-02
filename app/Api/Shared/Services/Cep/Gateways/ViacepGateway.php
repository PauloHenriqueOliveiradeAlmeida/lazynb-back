<?php

namespace App\Api\Shared\Services\Cep\Gateways;

use App\Api\Shared\Services\Cep\Dtos\AddressDto;
use App\Api\Shared\Services\Cep\ICep;
use Raven\Falcon\Http\Exceptions\BadRequestException;

class ViacepGateway implements ICep
{
	public function getAddress(string $cep): AddressDto
	{
		$response = file_get_contents("https://viacep.com.br/ws/$cep/json");
		if (empty($response)) throw new BadRequestException("CEP inválido");

		$response = json_decode($response);
		if (isset($response->erro)) throw new BadRequestException('CEP inválido');

		return new AddressDto(city: $response->localidade, uf: $response->uf, cep: $response->cep, neighborhood: $response->bairro);
	}
}
