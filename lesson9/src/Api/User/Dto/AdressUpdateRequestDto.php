<?php

declare(strict_types=1);

namespace App\Api\User\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserUpdateRequestDto
{
/**
     * @Assert\Length(max=30, min=3)
     */
    public ?string $country = null;

    public string $city;

    public string $street;
    /**
     * @Assert\Length(6)
     */
    public ?string $index = null;

    /**
     * @Assert\Length(max=15)
     */
    public ?string $user;
}
