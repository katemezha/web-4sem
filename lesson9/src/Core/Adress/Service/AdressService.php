<?php

declare(strict_types=1);

namespace App\Core\Adress\Service;

use App\Api\Adress\Dto\AdressCreateRequestDto;
use App\Api\Adress\Dto\AdressUpdateRequestDto;
use App\Core\Adress\Document\Adress;
use App\Core\Adress\Factory\AdressFactory;
use App\Core\Adress\Repository\AdressRepository;

use Psr\Log\LoggerInterface;

class AdressService
{
    /**
     * @var AdressRepository
     */
    private AdressRepository $adressRepository;

    /**
     * @var AdressFactory
     */
    private AdressFactory $adressFactory;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(
        AdressRepository $adressRepository,
        AdressFactory $adressFactory,
        LoggerInterface $logger
    ) {
        $this->adressRepository = $adressRepository;
        $this->adressFactory    = $adressFactory;
        $this->logger            = $logger;
    }

    public function findOneBy(array $criteria): ?Adress
    {
        return $this->adressRepository->findOneBy($criteria);
    }

    public function updateAdress(AdressUpdateRequestDto $requestDto) :Adress
    {
        $adress = $this->adressFactory->update(
            $requestDto->country,
            $requestDto->city,
            $requestDto->street,
            $requestDto->index,
            $requestDto->user,
        );

        $adress->setCountry($requestDto->country);
        $adress->setCity($requestDto->city);
        $adress->setStreet($requestDto->street);
        $adress->setIndex($requestDto->index);
        $adress->setUser($requestDto->user);

        $adress = $this->adressRepository->save($adress);

        $this->logger->info(
            'Adress updated successfully',
            [
                'adress_id'   => $adress->getId(),
                'adress_country' => $adress->getCountry(),
            ]
        );

        return $adress;
    }

    public function createAdress(AdressCreateRequestDto $requestDto): Adress
    {
        $adress = $this->adressFactory->create(
            $requestDto->country,
            $requestDto->city,
            $requestDto->street,
            $requestDto->index,
            $requestDto->user,
        );

        $adress->setCountry($requestDto->country);
        $adress->setCity($requestDto->city);
        $adress->setStreet($requestDto->street);
        $adress->setIndex($requestDto->index);
        $adress->setUser($requestDto->user);

        $adress = $this->adressRepository->save($adress);

        $this->logger->info(
            'Adress created successfully',
            [
                'adress_id'   => $adress->getId(),
                'adress_country' => $adress->getCounry(),
            ]
        );

        return $adress;
    }
}
