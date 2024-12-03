<?php

namespace App\Api\Modules\Collaborator;

use App\Api\Modules\Auth\Entity\UserCodeEntity;
use App\Api\Modules\Collaborator\Dtos\CollaboratorDto;
use App\Api\Modules\Collaborator\Entity\CollaboratorEntity;
use App\Api\Shared\Filters\DatabaseOperation\DatabaseOperationFilter;
use App\Api\Shared\Guards\Dtos\TokenPayloadDto;
use App\Api\Shared\Services\Code\CodeService;
use App\Api\Shared\Services\Token\TokenService;
use PDOException;
use Raven\Falcon\Http\Exceptions\BadRequestException;
use Raven\Falcon\Http\Exceptions\NotFoundException;
use Raven\Falcon\Http\Response;
use Raven\Falcon\Http\StatusCode;

class CollaboratorService
{
	public function __construct(
		private readonly CollaboratorEntity $collaboratorEntity = new CollaboratorEntity,
		private readonly UserCodeEntity $userCodeEntity = new UserCodeEntity,
		private readonly CodeService $codeService = new CodeService,
		private readonly TokenService $tokenService = new TokenService,
		private readonly DatabaseOperationFilter $databaseOperationFilter = new DatabaseOperationFilter
	) {}

	public function create(CollaboratorDto $collaboratorDto)
	{
		try {
			$this->collaboratorEntity->create($collaboratorDto);
			return Response::sendBody(["message" => "colaborador criado com sucesso"], StatusCode::CREATED);
		} catch (PDOException $e) {
			$this->databaseOperationFilter->handle($e);
		}
	}

	public function getAll()
	{
		try {
			$collaborators = $this->collaboratorEntity->selectAll();
			$user = $_SESSION['user'];
			$filteredCollaborators = [...array_filter($collaborators, fn($collaborator) => $collaborator['id'] !== $user->id)];

			return Response::sendBody($filteredCollaborators);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}
	public function getById(int $id)
	{
		try {
			$collaborator = $this->collaboratorEntity->selectById($id);

			if (!$collaborator) throw new NotFoundException('Colaborador não encontrado');

			return Response::sendBody((array) $collaborator);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function update(int $id, CollaboratorDto $collaboratorDto)
	{
		try {
			$this->collaboratorEntity->update($id, $collaboratorDto);

			return Response::sendBody([
				"message" => "Colaborador editado com sucesso"
			]);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public  function delete(int $id)
	{
		try {
			$deletedCollaborator = $this->collaboratorEntity->delete($id);

			if (!$deletedCollaborator) throw new NotFoundException('Colaborador não encontrado');

			return Response::sendBody([
				"message" => "Colaborador excluído com sucesso"
			]);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}
}
