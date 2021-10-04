<?php

declare(strict_types=1);

namespace App\Api\Adress\Dto;

use App\Core\Adress\Validator\UserExists;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @AdressExists()
 */
class AdressCreateRequestDto
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
