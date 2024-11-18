<?php

namespace App\Api\Modules\Auth;

use App\Api\Modules\Auth\Dtos\FirstAccessDto;
use App\Api\Modules\Auth\Dtos\LoginDto;
use App\Api\Modules\Auth\Dtos\ResetPasswordDto;
use App\Api\Modules\Auth\Dtos\SendEmailDto;
use App\Api\Modules\Auth\Dtos\VerifyResetPasswordCodeDto;
use App\Api\Shared\Services\Mailer\Gateways\PhpMailerGateway;
use Raven\Falcon\Attributes\Controller;
use Raven\Falcon\Attributes\HttpMethods\Post;
use Raven\Falcon\Attributes\Request\Body;

#[Controller(endpoint: 'auth')]
class AuthController
{

	public function __construct(
		private readonly AuthService $authService = new AuthService(new PhpMailerGateway)
	) {}

	#[Post(endpoint: 'login')]
	public function login(#[Body] LoginDto $loginDto)
	{
		return $this->authService->login($loginDto);
	}

	#[Post(endpoint: 'send-first-access-email')]
	public function sendFirstAccessEmail(#[Body] SendEmailDto $sendFirstAccessEmailDto)
	{
		return $this->authService->sendFirstAccessEmail($sendFirstAccessEmailDto);
	}

	#[Post(endpoint: 'first-access')]
	public function firstAccess(#[Body] FirstAccessDto $firstAccessDto)
	{
		return $this->authService->firstAccess($firstAccessDto);
	}

	#[Post(endpoint: 'send-reset-password-email')]
	public function sendResetPasswordEmail(#[Body] SendEmailDto $sendResetPasswordEmailDto)
	{
		return $this->authService->sendResetPasswordEmail($sendResetPasswordEmailDto);
	}

	#[Post(endpoint: 'verify-reset-password-code')]
	public function verifyResetPasswordCode(#[Body] VerifyResetPasswordCodeDto $verifyResetPasswordCodeDto)
	{
		return $this->authService->verifyResetPasswordCode($verifyResetPasswordCodeDto);
	}

	#[Post(endpoint: 'reset-password')]
	public function resetPassword(#[Body] ResetPasswordDto $resetPasswordDto)
	{
		return $this->authService->resetPassword($resetPasswordDto);
	}
}
