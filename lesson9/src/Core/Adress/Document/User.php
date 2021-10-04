<?php

declare(strict_types=1);

namespace App\Core\Adress\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\Adress\Enum\Role;
use App\Core\Adress\Enum\UserStatus;
use App\Core\Adress\Repository\UserRepository;
use App\Core\User\Enum\Role as EnumRole;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document(repositoryClass=UserRepository::class, collection="users")
 */
class User extends AbstractDocument implements UserInterface
{
     /**
     * @MongoDB\Id
     */
    protected ?string $id = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $first_name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $last_name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $email;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $city_id = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $phone = null;

    /**
     * @var string[]
     *
     * @MongoDB\Field(type="collection")
     */
    protected array $roles = [];

    
    public function __construct(
        string $first_name,
        string $last_name,
        string $email,
        string $city_id,
        string $phone,
        array $roles
    ) {

        
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->city_id = $city_id;
        $this->phone = $phone;

        array_map([$this, 'addRole'], $roles);

        $this->addDefaultRole();
    }
/**
     * @return array<string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array<string> $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;

        $this->addDefaultRole();
    }

    public function addRole(string $role): void
    {
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
    }


    public function getId(): ?string
    {
        return $this->id;
    }


    public function setId(?string $id): void
    {
        $this->id = $id;
    }
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }


    public function setFirstName(?string $first_name): void
    {
        $this->first_name = $first_name;
    }


    public function getLastName(): ?string
    {
        return $this->last_name;
    }


    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }


    public function getCityId(): ?string
    {
        return $this->city_id;
    }


    public function setCityId(?string $city_id): void
    {
        $this->city_id = $city_id;
    }

    
    public function getPhone(): ?string
    {
        return $this->phone;
    }


    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    private function addDefaultRole(): void
    {
        $this->addRole(Role::USER);
    }

    public function getPassword(): string
    {
        return $this->phone;
    }

    public function getSalt(): string
    {
        return md5($this->name);
    }

    public function getUsername(): string
    {
        return $this->name;
    }

    public function eraseCredentials(): void
    {
    }
}
