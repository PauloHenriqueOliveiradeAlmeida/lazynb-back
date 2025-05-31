<?php

namespace App\Api\Shared\Services\Mailer\Gateways;

use App\Api\Shared\Services\Mailer\IMailer;

class MockMailerGateway implements IMailer {
	public function send(string $destination, string $subject, string $templateId, array $variables): bool {
		return true;
	}
}