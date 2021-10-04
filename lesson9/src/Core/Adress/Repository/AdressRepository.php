<?php

declare(strict_types=1);

namespace App\Core\Adress\Repository;

use App\Core\Common\Repository\AbstractRepository;
use App\Core\Adress\Document\Adress;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;

/**
 * @method Adress save(Adress $product)
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
     * @throws MappingException
     */
    public function getAdressById(string $id): ?AdressRepository
    {
        return $this->find($id);
    }
}
