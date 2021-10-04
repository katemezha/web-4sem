<?php

declare(strict_types=1);

namespace App\Core\Adress\Factory;

use App\Api\Adress\Controller\AdressController;
use App\Core\Adress\Document\Adress;

class AdressFactory
{
    public function create(
        string $country,
        string $city,
        string $street,
        string $inedx,
        string $user
    ): AdressController {
        $adress = new AdressController(
            $country,
            $city,
            $street,
            $inedx,
            $user
        );



        return $adress;
    }

    public function update(
        string $country,
        string $city,
        string $street,
        string $inedx,
        string $user
    ): AdressController{
        $adress = new AdressController(
            $country,
            $city,
            $street,
            $inedx,
            $user
        );



        return $adress;
    }
}
