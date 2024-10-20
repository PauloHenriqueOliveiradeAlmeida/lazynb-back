<?php

namespace App\Api\Modules\Client;

use App\Api\Modules\Client\Entity\ClientEntity;
use Exception;
use Raven\Falcon\Http\Response;
use Raven\Falcon\Http\StatusCode;
use PDOException;
use Raven\Falcon\Http\Exceptions\BadRequestException;
use Raven\Falcon\Http\Exceptions\NotFoundException;

class ClientService
{

	public function __construct(private readonly ClientEntity $clientEntity = new ClientEntity) {}

	public function create(ClientDto $clientDto)
	{
		try {
			$this->clientEntity->create($clientDto);
			return Response::sendBody([
				"message" => "Cliente criado com sucesso"
			], StatusCode::CREATED);
		} catch (Exception $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function getAll()
	{
		try {
			$clients = $this->clientEntity->selectAll();
			return Response::sendBody($clients);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function getById(int $id)
	{
		try {
			$client = $this->clientEntity->selectById($id);

			if (!$client) throw new BadRequestException('Cliente não encontrado');

			Response::sendBody($client);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function update(int $id, ClientDto $clientDto)
	{
		try {
			$this->clientEntity->update($id, $clientDto);
			Response::sendBody([
				"message" => "Cliente atualizado com sucesso"
			]);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}
	public function delete(int $id)
	{
		try {
			$deletedClient = $this->clientEntity->delete($id);

			if (!$deletedClient) throw new NotFoundException("Cliente não encontrado");

			Response::sendBody([
				"message" => "Cliente removido com sucesso"
			]);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}
}
