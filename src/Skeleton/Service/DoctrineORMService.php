<?php

namespace Skeleton\Service;

use Interop\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\DBAL\Types\Type;

/**
 * Class DoctrineORMService
 * @package Skeleton\Service
 * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
 */
class DoctrineORMService
{

    /**
     * @var bool isDevelopment
     */
    private $isDevelopment = true;

    /**
     * @var array configOptions
     */
    private $configOptions;

    /**
     * @var array connectionOptions
     */
    private $connectionOptions;

    /**
     * @var array customOptions
     */
    private $customOptions;

    /**
     * __invoke
     * @param ContainerInterface $ci
     * @return EntityManager
     */
    public function __invoke(ContainerInterface $ci)
    {
        $settings = $ci->get('settings');
        $this->isDevelopment = $settings['environment']['isDevelopment'];
        $this->configOptions = $settings['doctrine']['config'];
        $this->connectionOptions = $settings['doctrine']['connection'];

        if (isset($settings['doctrine']['custom'])) {
            $this->customOptions = $settings['doctrine']['custom'];
            $this->applyCustomOption();
        }

        $config = new Configuration;
        $cache = $this->getCacheType($this->configOptions['doctrine.cache.type']);
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);

        $driverImpl = $config->newDefaultAnnotationDriver($this->configOptions['doctrine.entity.path'], false);
        $config->setMetadataDriverImpl($driverImpl);

        $config->setProxyDir($this->configOptions['doctrine.proxy.dir']);
        $config->setProxyNamespace($this->configOptions['doctrine.proxy.namespace']);

        if ($this->isDevelopment) {
            $config->setAutoGenerateProxyClasses(true);
        } else {
            $config->setAutoGenerateProxyClasses(false);
        }

        if (!$this->isDevelopment) {
            $config->ensureProductionSettings();
        }

        $entityManager = EntityManager::create($this->connectionOptions, $config);
        return $entityManager;
    }

    /**
     * Method to get the relative cache type informed in settings
     * @param string $cacheType
     * @return \Doctrine\Common\Cache\RedisCache
     */
    private function getCacheType($cacheType = '', $useArrayCacheOnDevelopment = true)
    {

        if ($useArrayCacheOnDevelopment && $this->isDevelopment) {
            $cache = new \Doctrine\Common\Cache\ArrayCache();
        } else {
            switch ($cacheType) {
                case 'redis':
                    $cache = new \Doctrine\Common\Cache\RedisCache();
                    break;

                case 'apc':
                    $cache = new \Doctrine\Common\Cache\ApcCache();
                    break;

                case 'apcu':
                    $cache = new \Doctrine\Common\Cache\ApcuCache();
                    break;

                case 'memcache':
                    $cache = new \Doctrine\Common\Cache\MemcacheCache();
                    break;

                case 'memcached':
                    $cache = new \Doctrine\Common\Cache\MemcachedCache();
                    break;

                default:
                    $cache = new \Doctrine\Common\Cache\ArrayCache();
                    break;
            }
        }

        return $cache;
    }

    /**
     * @todo Apply all available custom options for doctrine.
     * @return void
     */
    private function applyCustomOption()
    {
        if (array_key_exists('types', $this->customOptions)) {
            array_walk($this->customOptions['types'], [$this, 'addType']);
        }
    }

    /**
     * Add custom type to Doctrine
     * @param $name
     * @param $className
     * @return void
     */
    private function addType($className, $name)
    {
        return Type::addType($name, $className);
    }
}
