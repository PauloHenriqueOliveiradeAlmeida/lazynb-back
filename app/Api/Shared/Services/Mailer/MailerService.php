<?php

namespace App\Api\Shared\Services\Mailer;

class MailerService
{
	public function __construct(
		private readonly IMailer $mailerGateway
	) {}

	public function sendRegistrationCode(string $destination)
	{
		return $this->mailerGateway->send($destination, 'Bem-vindo ao Staynb!', getenv("MAILER_REGISTRATION_TEMPLATE_ID"), [
			'verification_code' => bin2hex(random_bytes(4))
		]);
	}
}
