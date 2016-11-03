<?php
namespace Skeleton\Service;

use Interop\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
//use Doctrine\DBAL\Types\Type;

/**
 * Class DoctrineORMService
 * @package Skeleton\Service
 * @todo implement uuid type to handle entity Id https://packagist.org/packages/ramsey/uuid-doctrine
 * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
 */
class DoctrineORMService
{

    /**
     * Invokable constructor method
     * @param ContainerInterface $ci
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Interop\Container\Exception\NotFoundException
     */
    public function __invoke(ContainerInterface $ci)
    {
        $settings = $ci->get('settings');

        $config = Setup::createAnnotationMetadataConfiguration(
            $settings['doctrine']['meta']['entity_path'],
            $settings['doctrine']['meta']['auto_generate_proxies'],
            $settings['doctrine']['meta']['proxy_dir'],
            $settings['doctrine']['meta']['cache'],
            false
        );

        $entityManager = EntityManager::create(
            $settings['doctrine']['connection'],
            $config
        );

        return $entityManager;
//        Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
//        $entityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
    }
}