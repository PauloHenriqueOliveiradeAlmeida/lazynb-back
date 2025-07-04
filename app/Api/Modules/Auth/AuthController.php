<?php

namespace App\Api\Modules\Auth;

use App\Api\Modules\Auth\Dtos\FirstAccessDto;
use App\Api\Modules\Auth\Dtos\LoginDto;
use App\Api\Modules\Auth\Dtos\ResetPasswordDto;
use App\Api\Modules\Auth\Dtos\SendEmailDto;
use App\Api\Modules\Auth\Dtos\VerifyResetPasswordCodeDto;
use App\Api\Shared\Guards\Enums\UserLevelEnum;
use App\Api\Shared\Guards\UserGuard;
use Raven\Falcon\Attributes\Controller;
use Raven\Falcon\Attributes\HttpMethods\Get;
use Raven\Falcon\Attributes\HttpMethods\Post;
use Raven\Falcon\Attributes\Middlewares\Guard\UseGuard;
use Raven\Falcon\Attributes\Request\Body;
use App\Api\Shared\Services\Mailer\Gateways\MockMailerGateway;

#[Controller(endpoint: 'auth')]
class AuthController
{

	public function __construct(
		private readonly AuthService $authService = new AuthService(new MockMailerGateway())
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

	#[Get(endpoint: 'details')]
	#[UseGuard(new UserGuard(UserLevelEnum::ALL))]
	public function getUserDetails()
	{
		return $this->authService->getUserDetails();
	}
}
