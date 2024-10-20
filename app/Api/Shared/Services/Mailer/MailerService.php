<?php

namespace App\Api\Shared\Services\Mailer;

class MailerService
{
	public function __construct(
		private readonly IMailer $mailerGateway
	) {}

	public function sendRegistrationCode(string $destination, string $verificationCode)
	{
		return $this->mailerGateway->send($destination, 'Bem-vindo ao Staynb!', getenv("MAILER_REGISTRATION_TEMPLATE_ID"), [
			'verification_code' => $verificationCode
		]);
	}

	public function sendResetPassword(string $destination, string $verificationCode)
	{
		return $this->mailerGateway->send($destination, 'Redefinição de senha', getenv("MAILER_RESET_PASSWORD_TEMPLATE_ID"), [
			'verification_code' => $verificationCode
		]);
	}
}
