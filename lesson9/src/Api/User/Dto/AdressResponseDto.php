<?php

declare(strict_types=1);

namespace App\Api\Adress\Dto;

use App\Api\Adress\Dto\UserResponseDto as DtoUserResponseDto;


class AdressResponseDto
{
    public ?string $id;

    public ?string $country = null;

    public string $city;

    public string $street;

    public ?string $index = null;

    public ?string $roleHumanReadable;

    public DtoUserResponseDto $user;

}

