<?php

declare(strict_types=1);

namespace App\Api\User\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserCreateRequestDto
{
    /**
     * @Assert\Length(max=20, min=3)
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z0-9@]*$/",
     *      message="Incorrect")
     */


    public ?string $firstName = null;

     /**
     * @Assert\Length(max=30, min=3)
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z0-9@]*$/",
     *      message="Incorrect")
     */

    public ?string $lastName = null;

    /**
     * @Assert\Length(11)
     */
    public string $phone = '';

    public ?string $apiToken = null;

    /**
     * @Assert\Choice(callback={"App\Core\User\Enum\Role", "getValues"}, multiple=true)
     */
    public array $roles = [];
}
