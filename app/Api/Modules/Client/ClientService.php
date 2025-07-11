<?php

namespace App\Api\Modules\Client;

use App\Api\Modules\Client\Dtos\ClientDto;
use App\Api\Modules\Client\Entity\ClientEntity;
use App\Api\Modules\Property\Entity\PropertyEntity;
use App\Api\Shared\Filters\DatabaseOperation\DatabaseOperationFilter;
use App\Api\Shared\Services\Mailer\Dtos\SendConversationInviteDto;
use App\Api\Shared\Services\Mailer\IMailer;
use App\Api\Shared\Services\Mailer\MailerService;
use Exception;
use Raven\Falcon\Http\Response;
use Raven\Falcon\Http\StatusCode;
use PDOException;
use Raven\Falcon\Http\Exceptions\BadRequestException;
use Raven\Falcon\Http\Exceptions\NotFoundException;
use App\Api\Shared\Services\Log\LogService;
use App\Api\Shared\Database\MongoDBConnection;

class ClientService
{
	private MailerService $mailerService;
	private LogService $logService;
	public function __construct(
		IMailer $iMailer,
		private readonly ClientEntity $clientEntity = new ClientEntity,
		private readonly PropertyEntity $propertyEntity = new PropertyEntity,
		private readonly DatabaseOperationFilter $databaseOperationFilter = new DatabaseOperationFilter
	) {
		$this->logService = new LogService(MongoDBConnection::getDatabase());
		$this->mailerService = new MailerService($iMailer);
	}

	public function create(ClientDto $clientDto)
	{
		try {
			$this->clientEntity->create($clientDto);

			$this->logService->logClientCreation(
                $clientDto->name,
                $clientDto->email
            );

			return Response::sendBody([
				"message" => "Cliente criado com sucesso"
			], StatusCode::CREATED);
		} catch (Exception $e) {
			$this->databaseOperationFilter->handle($e);
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

			return Response::sendBody($client);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function update(int $id, ClientDto $clientDto)
	{
		try {
			$this->clientEntity->update($id, $clientDto);

			return Response::sendBody([
				"message" => "Cliente atualizado com sucesso"
			]);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}
	public function delete(int $id)
	{
		try {
			$this->propertyEntity->selectByClientId($id);
			
			if ($this->propertyEntity->selectByClientId($id)) throw new BadRequestException("Cliente possui imóveis cadastrados");
			
			$deletedClient = $this->clientEntity->delete($id);
			
			if (!$deletedClient) throw new NotFoundException("Cliente não encontrado");
			
			$this->logService->logClientDelete(
				$client_id = $id
			);
			return Response::sendBody([
				"message" => "Cliente removido com sucesso"
			]);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function sendConversationInviteEmail(SendConversationInviteDto $sendConversationInviteDto)
	{
		$this->mailerService->sendConversationInvite(getenv("TALK_TO_US_EMAIL"), $sendConversationInviteDto);

		return Response::sendBody([
			"message" => "Email de contato enviado com sucesso"
		]);
	}
}
