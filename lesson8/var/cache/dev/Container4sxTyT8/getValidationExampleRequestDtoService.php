<?php

namespace Container4sxTyT8;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getValidationExampleRequestDtoService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Api\User\Dto\ValidationExampleRequestDto' shared autowired service.
     *
     * @return \App\Api\User\Dto\ValidationExampleRequestDto
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/Api/User/Dto/ValidationExampleRequestDto.php';

        return $container->privates['App\\Api\\User\\Dto\\ValidationExampleRequestDto'] = new \App\Api\User\Dto\ValidationExampleRequestDto();
    }
}
