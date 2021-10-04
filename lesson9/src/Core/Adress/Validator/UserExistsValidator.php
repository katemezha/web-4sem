<?php

declare(strict_types=1);

namespace App\Core\Adress\Validator;

use App\Core\Adress\Service\AdressService as ServiceAdressService;
use Symfony\Component\Security\Core\Exception\AuthenticationExpiredException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ProductExistsValidator extends ConstraintValidator
{
    /**
     * @var ServiceAdressService
     */
    private ServiceAdressService $service;

    public function __construct(ServiceAdressService $service)
    {
        $this->service = $service;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof AdressExists) {
            throw new UnexpectedTypeException($constraint, AdressExists::class);
        }

        $adress = $this->adressService->findOneBy(['title' => $value->title]);

        if ($adress) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ adressId }}', $adress->getId())
                ->addViolation();
        }
    }
}
