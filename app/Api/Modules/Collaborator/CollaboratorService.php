<?php

namespace App\Api\Modules\Collaborator;

use App\Api\Modules\Auth\Entity\UserCodeEntity;
use App\Api\Modules\Collaborator\Dtos\CollaboratorDto;
use App\Api\Modules\Collaborator\Entity\CollaboratorEntity;
use App\Api\Shared\Services\Code\CodeService;
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
		private readonly CodeService $codeService = new CodeService
	) {}

	public function create(CollaboratorDto $collaboratorDto)
	{
		try {
			$this->collaboratorEntity->create($collaboratorDto);


			return Response::sendBody(["message" => "colaborador criado com sucesso"], StatusCode::CREATED);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public function getAll()
	{
		try {
			$collaborators = $this->collaboratorEntity->selectAll();

			return Response::sendBody($collaborators);
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
