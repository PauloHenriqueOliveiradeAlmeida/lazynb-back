<?php

namespace App\Api\Shared\Services\Mailer\Gateways;

use App\Api\Shared\Services\Mailer\IMailer;
use Exception;
use MailerSend\Helpers\Builder\EmailParams;
use MailerSend\Helpers\Builder\Personalization;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\MailerSend;
use Raven\Falcon\Http\Exceptions\ServiceUnavailableException;

class MailerSendGateway implements IMailer
{
	private readonly MailerSend $mailerSend;
	public function __construct()
	{
		$this->mailerSend = new MailerSend(['api_key' => getenv("MAILER_API_KEY")]);
	}

	public function send(string $destination, string $subject, string $templateId, array $variables): bool
	{
		try {
			$recipient = new Recipient($destination, 'recipient');
			$personalization = new Personalization($destination, $variables);

			$params = (new EmailParams())
				->setFrom(getenv("MAILER_DOMAIN"))
				->setFromName('Lazynb')
				->setRecipients([$recipient])
				->setTemplateId($templateId)
				->setPersonalization([$personalization])
				->setSubject($subject);

			$this->mailerSend->email->send($params);
			return true;
		} catch (Exception $e) {
			throw new ServiceUnavailableException($e->getMessage());
		}
	}
}
