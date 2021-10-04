<?php

declare(strict_types=1);

namespace App\Core\Adress\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AdressExists extends Constraint
{
    public $message = 'Adress already exists, id: {{ adressId }}';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
