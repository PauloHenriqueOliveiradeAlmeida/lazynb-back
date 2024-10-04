<?php

namespace App\Api\Shared\Services\Mailer;

interface IMailer
{
	public function send(string $destination, string $subject, string $templateId, array $variables): bool;
}
