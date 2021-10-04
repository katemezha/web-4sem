<?php

declare(strict_types=1);

namespace App\Api\User\Dto;


class UserResponseDto
{
    public ?string $id;

    public ?string $name;

    public ?string $surname;

    public string $phone;

    public ?string $roles;

    public ?string $token;

    public ?AdressResponseDto $adress;
}
