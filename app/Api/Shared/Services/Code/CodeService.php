<?php

namespace App\Api\Shared\Services\Code;

class CodeService
{
	public function generateRandom()
	{
		return bin2hex(random_bytes(4));
	}
}
