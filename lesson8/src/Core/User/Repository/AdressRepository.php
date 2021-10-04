<?php

declare(strict_types=1);

namespace App\Core\User\Repository;


use App\Core\Common\Repository\AbstractRepository;
use App\Core\User\Document\Adress;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;

/**
 * @method Adress save(Adress $user)
 * @method Adress|null find(string $id)
 * @method Adress|null findOneBy(array $criteria)
 * @method Adress getOne(string $id)
 */
class AdressRepository extends AbstractRepository
{
    public function getDocumentClassName(): string
    {
        return Adress::class;
    }

    /**
     * @throws LockException
     * @throws MappingException|MappingException
     */
    public function getAdressById(string $id): ?Adress
    {
        return $this->find($id);
    }
}
