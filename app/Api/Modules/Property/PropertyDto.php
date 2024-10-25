<?php

namespace App\Api\Modules\Property;

use Raven\Cassowary\Validators\IsInteger;
use Raven\Cassowary\Validators\IsRequired;
use Raven\Cassowary\Validators\IsString;
use Raven\Cassowary\Validators\Length;

class PropertyDto
{
    #[IsRequired]
    #[IsString]
    #[Length(min: 3, max: 100)]
    public string $name;

    #[IsRequired]
    #[IsString]
    #[Length(min: 8, max: 9)]
    public string $cep;

    #[IsRequired]
    #[IsString]
    #[Length(min: 3, max: 100)]
    public string $neighborhood;

    #[IsRequired]
    #[IsInteger]
    #[Length(min: 1, max: 10)]
    public int $address_number;

    #[IsString]
    #[Length(min: 3, max: 100)]
    public ?string $complement = null;

    #[IsRequired]
    #[IsString]
    #[Length(min: 1, max: 100)]
    public string $city;

    #[IsRequired]
    #[IsString]
    #[Length(min: 1, max: 3)]
    public string $uf;

    #[IsRequired]
    #[IsString]
    #[Length(min: 3, max: 300)]
    public string $description;

    #[IsInteger]
    public ?int $clientid = null;

    #[IsRequired]
    public array $amenities = [];
}
