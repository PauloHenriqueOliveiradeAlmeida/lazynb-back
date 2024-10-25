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

	/**
	 * @template T
	 * @param class-string<T> $payloadType
	 * @return T
	 **/
	public function getPayload(string $token, string $secret, string $payloadType)
	{
		[$headers, $payloadEncoded, $signature] = explode('.', $token);

		$secretHash = $this->encode(hash_hmac('sha512', "$headers.$payloadEncoded", $secret, true));

		$payloadArray = json_decode($this->decode($payloadEncoded));

		if ($signature !== $secretHash)
			throw new BadRequestException('Token inválido');

		$payload = new $payloadType();
		foreach ($payloadArray as $key => $value) {
			$payload->{$key} = $value;
		}
		return $payload;
	}

	private function encode(string $value)
	{
		return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
	}
	private function decode(string $value)
	{
		return base64_decode(
			strtr(
				$value,
				'-_',
				'+/'
			)
		);
	}
}
