<?php

namespace App\Api\Shared\Services\Token;

use Raven\Falcon\Http\Exceptions\BadRequestException;

class TokenService
{
	public function generate(array $payload, string $secret)
	{
		$headers = $this->encode(json_encode(["alg" => "HS512"]));
		$payloadEncoded = $this->encode(json_encode($payload));
		$signature = $this->encode(hash_hmac('sha512', "$headers.$payloadEncoded", $secret, true));

		return "$headers.$payloadEncoded.$signature";
	}

	public function getPayload(string $token, string $secret)
	{
		[$headers, $payloadEncoded, $signature] = explode('.', $token);

		$secretHash = $this->encode(hash_hmac('sha512', "$headers.$payloadEncoded", $secret, true));

		$payload = json_decode($this->decode($payloadEncoded));

		if ($signature !== $secretHash)
			throw new BadRequestException('Token inválido');

		return $payload;
	}

	private function encode(string $value)
	{
		return str_replace(
			['+', '/', '='],
			['-', '_', ''],
			base64_encode($value)
		);
	}
	private function decode(string $value)
	{
		return str_replace(
			['-', '_', ''],
			['+', '/', '='],
			base64_decode($value)
		);
	}
}
