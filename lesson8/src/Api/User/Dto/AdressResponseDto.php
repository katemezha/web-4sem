<?php

declare(strict_types=1);

namespace App\Api\User\Dto;

class AdressResponseDto
{
    public ?string $id = null;

    public string $city;

    public string $street;
}
