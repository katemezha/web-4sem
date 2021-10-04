<?php

declare(strict_types=1);

namespace App\Core\Adress\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\Adress\Repository\AdressRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * @MongoDB\Document(repositoryClass=ContactRepository::class, collection="contacts")
 */
class Contact extends AbstractDocument
{   
    /**
     * @MongoDB\Id
     */
    protected ?string $id = null;

    /**
     * @MongoDB\Field(type="string")
   
     */
    protected ?string $country;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $city;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $street;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $index;


    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $user;


    public function __construct(
        string $country,
        string $city,
        string $street,
        string $index,
        string $user
    ) {
        $this->country = $country;
        $this->city = $city;
        $this->street =$street;
        $this->index =$index;
        $this->user = $user;
    }


    public function getCountry(): ?string
    {
        return $this->country;
    }


    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }


    public function getCity(): ?string
    {
        return $this->city;
    }


    public function setCity(?string $city): void
    {
        $this->city = $city;
    }


    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }


    public function getIndex(): string
    {
        return $this->index;
    }


    public function seIndex(string $index): void
    {
        $this->index = $index;
    }



    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): void
    {
        $this->user = $user;
    }


}
