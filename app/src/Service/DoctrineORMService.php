<?php
namespace Skeleton\Service;

use \Interop\Container\ContainerInterface;
use \Doctrine\ORM\EntityManager;
use \Doctrine\ORM\Tools\Setup;

class DoctrineORMService
{

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
        
        return EntityManager::create(
            $settings['doctrine']['connection'], 
            $config
        );
    }
}