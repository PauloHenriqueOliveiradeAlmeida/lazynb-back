<?php

namespace App\Api\Shared\Services\Mailer\Gateways;

use App\Api\Shared\Services\Mailer\Gateways\Templates\FirstAccessTemplate;
use App\Api\Shared\Services\Mailer\IMailer;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Raven\Falcon\Http\Exceptions\ServiceUnavailableException;

class PhpMailerGateway implements IMailer
{
	private readonly PHPMailer $phpMailer;
	public function __construct()
	{
		$this->phpMailer = new PHPMailer();
		$this->phpMailer->isSMTP();
		$this->phpMailer->Host = getenv("MAILER_HOST");
		$this->phpMailer->SMTPAuth = true;
		$this->phpMailer->Port = getenv("MAILER_PORT");
		$this->phpMailer->Username = getenv("MAILER_USERNAME");
		$this->phpMailer->Password = getenv("MAILER_PASSWORD");
	}

	public function send(string $destination, string $subject, string $templateId, array $variables): bool
	{
		try {
			$this->phpMailer->addAddress($destination, 'recipient');

			$this->phpMailer->FromName = 'Lazynb';
			$this->phpMailer->msgHTML((new FirstAccessTemplate())->render($variables['verification_code']));
			$this->phpMailer->Subject = $subject;
			return $this->phpMailer->send();
		} catch (Exception $e) {
			throw new ServiceUnavailableException($e->getMessage());
		}
	}
}
