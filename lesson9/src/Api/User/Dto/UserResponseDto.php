<?php

declare(strict_types=1);

namespace App\Api\Adress\Dto;


use Symfony\Component\Validator\Constraints as Assert;

class UserResponseDto
{
    public ?string $id;

    public ?string $first_name;

    public ?string $last_name;

    public string $email;

    public ?string $city_id;

    public ?string $phone;

    public array $roles;


}
