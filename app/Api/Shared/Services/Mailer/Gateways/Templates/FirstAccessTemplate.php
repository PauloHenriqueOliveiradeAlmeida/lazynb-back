<?php

namespace App\Api\Shared\Services\Mailer\Gateways\Templates;

class FirstAccessTemplate
{
	public function render(string $verificationCode)
	{
		return ?><h1>Bem-vindo ao Lazynb!</h1>
		<p>Seu codigo de acesso é: <b><?= $verificationCode ?></b></p>

<?php }
}
