<?php

namespace App\Api\Modules\Collaborator;

use App\Api\Modules\Collaborator\Dtos\CollaboratorDto;
use App\Api\Modules\Collaborator\Entity\CollaboratorEntity;
use App\Api\Shared\Services\Mailer\IMailer;
use App\Api\Shared\Services\Mailer\MailerService;
use PDOException;
use Raven\Falcon\Http\Exceptions\BadRequestException;
use Raven\Falcon\Http\Response;
use Raven\Falcon\Http\StatusCode;

class CollaboratorService
{
	private readonly MailerService $mailerService;
	public function __construct(
		IMailer $iMailer,
		private readonly CollaboratorEntity $collaboratorEntity = new CollaboratorEntity,
	) {
		$this->mailerService = new MailerService($iMailer);
	}

	public function create(CollaboratorDto $collaboratorDto)
	{
		try {
			$this->collaboratorEntity->create($collaboratorDto);
			$this->mailerService->sendRegistrationCode($collaboratorDto->email);

			Response::sendBody(["message" => "colaborador criado com sucesso"], StatusCode::CREATED);
		} catch (PDOException $e) {
			throw new BadRequestException($e->getMessage());
		}
	}

	public static function getAll()
	{
		try {
			$collaborator = new Collaborator();
			HttpResponse::sendBody($collaborator->selectAll());
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["error" => $e], HttpResponse::SERVER_ERROR);
		}
	}
	public static function getById($id)
	{
		try {
			$collaborator = new Collaborator();
			HttpResponse::sendBody($collaborator->selectById($id));
		} catch (mysqli_sql_exception $e) {
			HttpResponse::sendBody(["error" => $e], HttpResponse::SERVER_ERROR);
		}
	}

	public static function update($id, CollaboratorDto $collaboratorDto)
	{
		try {
			$dto = CollaboratorDTO::validate(...array_diff_key($data, ['password' => '']));
			$password = password_hash($data['password'], PASSWORD_DEFAULT, [
				'cost' => 15
			]);
			$collaborator = new Collaborator(...$dto, password: $password);
			$collaborator->update($id);

			HttpResponse::sendBody([
				"message" => "Colaborador editado com sucesso"
			]);
		} catch (mysqli_sql_exception $e) {
			switch ($e->getCode()) {
				case 1062:
					HttpResponse::send(HttpResponse::CONFLICT);
				case 1049:
					HttpResponse::send(HttpResponse::NOT_FOUND);
			}
		}
	}

	public static function patch($id, array $data)
	{
		try {
			$dto = CollaboratorDTO::validate(...$data);
			$collaborator = new Collaborator(...$dto);

			$collaborator->patch($id);

			HttpResponse::sendBody([
				"message" => "Colaborador editado com sucesso"
			]);
		} catch (mysqli_sql_exception $e) {
			switch ($e->getCode()) {
				case 1062:
					HttpResponse::send(HttpResponse::CONFLICT);
				case 1049:
					HttpResponse::send(HttpResponse::NOT_FOUND);
				default:
					HttpResponse::sendBody(["error" => $e->getMessage()], HttpResponse::SERVER_ERROR);
			}
		}
	}

	public static function delete($id)
	{
		try {
			$collaborator = new Collaborator();
			$collaborator->delete($id);

			HttpResponse::sendBody([
				"message" => "Colaborador excluído com sucesso"
			]);
		} catch (mysqli_sql_exception $e) {
			switch ($e->getCode()) {
				case 1329:
					HttpResponse::send(HttpResponse::NOT_FOUND);
				case 1049:
					HttpResponse::send(HttpResponse::NOT_FOUND);
			}
		}
	}

	public static function login(array $data)
	{
		try {
			$dto = LoginDTO::validate(...$data);
			$collaborator = new Collaborator();
			$collaborator_datas = $collaborator->selectByEmail($dto['email']);

			if (count($collaborator_datas) === 0) {
				HttpResponse::sendBody([
					'message' => 'Não há nenhum registro com esse email, tente outro email'
				], HttpResponse::NOT_FOUND);
			}

			Auth::login($collaborator_datas, $data['password']);

			HttpResponse::sendBody([
				"message" => "Login efetuado com sucesso"
			]);
		} catch (mysqli_sql_exception $error) {
			HttpResponse::sendBody(["message" => $error->getMessage()], HttpResponse::SERVER_ERROR);
		}
	}

	public static function logout()
	{
		Auth::logout();
		HttpResponse::sendBody([
			"message" => "Logout efetuado com sucesso"
		], HttpResponse::OK);
	}
}
