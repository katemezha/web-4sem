<?php

declare(strict_types=1);

namespace App\Core\User\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\User\Repository\AdressRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * @MongoDB\Document(repositoryClass=AdressRepository::class, collection="adress")
 */
class Adress extends AbstractDocument
{
    /**
     * @MongoDB\Id
     */
    protected ?string $id = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $city;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $street;

    /**
     * @ReferenceOne(targetDocument=User::class)
     */
    protected User $user;

    public function __construct(string $city, string $street, User $user)
    {   
        $this->city = $city;
        $this->street  = $street;
        $this->user  = $user;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
