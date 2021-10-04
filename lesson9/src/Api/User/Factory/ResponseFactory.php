<?php

declare(strict_types=1);

namespace App\Api\User\Factory;

use App\Api\Adress\Dto\UserResponseDto;
use App\Api\Adress\Dto\AdressResponseDto;
use App\Core\Adress\Document\Adress;
use App\Core\Adress\Document\User;
use App\Core\Adress\Enum\Role;
use App\Core\Adress\Enum\RoleHumanReadable;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    /**
     * @param User    $user
     * @param Adress|null $adress
     *
     * @return UserResponseDto
     */
    public function createAdressResponse(User $user, ?Adress $adress = null): UserResponseDto
    {
        $dto = new AdressResponseDto();

        $userResponseDto             = new UserResponseDto();
       
        $userResponseDto->first_name = $user->getFirstName();
        $userResponseDto->last_name  = $user->getLastName();
        
       
  
        $userResponseDto->phone      = $user->getPhone();
        $userResponseDto->roleHumanReadable      = $user->getRoleHumanReadable();
        $userResponseDto->token      = $user->getToken();

       
       

        
        if($adress){
           
            $dto->id                = $adress->getId();
            $dto->country         = $adress->getCountry();
            $dto->city          = $adress->getCity();
            $dto->street             = $adress->getStreet();
            $dto->index              = $adress->getIndex($adress);

            $dto->adress = $adressResponseDto;
        }

        return $dto;
    }
}
