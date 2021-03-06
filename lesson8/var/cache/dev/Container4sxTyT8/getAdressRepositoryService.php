<?php

namespace Container4sxTyT8;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getAdressRepositoryService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Core\User\Repository\AdressRepository' shared autowired service.
     *
     * @return \App\Core\User\Repository\AdressRepository
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectRepository.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/collections/lib/Doctrine/Common/Collections/Selectable.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/mongodb-odm/lib/Doctrine/ODM/MongoDB/Repository/DocumentRepository.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/mongodb-odm-bundle/Repository/ServiceDocumentRepositoryInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/mongodb-odm-bundle/Repository/ServiceRepositoryTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/mongodb-odm-bundle/Repository/ServiceDocumentRepository.php';
        include_once \dirname(__DIR__, 4).'/src/Core/Common/Repository/AbstractRepository.php';
        include_once \dirname(__DIR__, 4).'/src/Core/User/Repository/AdressRepository.php';

        return $container->privates['App\\Core\\User\\Repository\\AdressRepository'] = new \App\Core\User\Repository\AdressRepository(($container->services['doctrine_mongodb'] ?? $container->getDoctrineMongodbService()));
    }
}
