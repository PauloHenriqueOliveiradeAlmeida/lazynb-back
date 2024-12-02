<?php

namespace App\Api\Shared\Services\Code;

class CodeService
{
	public function generateRandom()
	{
		return rand(100000, 999999);
	}
}
