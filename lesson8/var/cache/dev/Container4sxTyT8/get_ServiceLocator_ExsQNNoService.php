<?php

namespace Container4sxTyT8;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_ExsQNNoService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.ExsQNNo' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.ExsQNNo'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'requestDto' => ['privates', 'App\\Api\\User\\Dto\\UserCreateRequestDto', 'getUserCreateRequestDtoService', true],
            'userRepository' => ['privates', 'App\\Core\\User\\Repository\\UserRepository', 'getUserRepositoryService', true],
            'validationErrors' => ['privates', '.errored..service_locator.ExsQNNo.Symfony\\Component\\Validator\\ConstraintViolationListInterface', NULL, 'Cannot autowire service ".service_locator.ExsQNNo": it references interface "Symfony\\Component\\Validator\\ConstraintViolationListInterface" but no such service exists. Did you create a class that implements this interface?'],
        ], [
            'requestDto' => 'App\\Api\\User\\Dto\\UserCreateRequestDto',
            'userRepository' => 'App\\Core\\User\\Repository\\UserRepository',
            'validationErrors' => 'Symfony\\Component\\Validator\\ConstraintViolationListInterface',
        ]);
    }
}
