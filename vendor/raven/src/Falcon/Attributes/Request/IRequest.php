<?php

namespace Raven\Falcon\Attributes\Request;

interface IRequest
{
	/*
	* @param ?object|string[] $request
	**/
	public function convertRequestToData($request, string $dataType);
}
