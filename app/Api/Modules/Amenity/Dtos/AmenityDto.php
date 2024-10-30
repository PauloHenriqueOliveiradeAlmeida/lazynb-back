<?php

namespace App\Api\Modules\Amenity\Dtos;

use Raven\Cassowary\Validators\IsRequired;
use Raven\Cassowary\Validators\IsString;
use Raven\Cassowary\Validators\Length;

class AmenityDto
{
	#[IsRequired]
	#[IsString]
	#[Length(min: 3, max: 100)]
	public string $name;
}
