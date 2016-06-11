<?php
defined('APPPATH') || define('APPPATH', dirname(__DIR__));
require_once (APPPATH . "/vendor/autoload.php");

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$settings = require_once (APPPATH . "/config/config.php");
$settings = $settings['settings']['doctrine'];

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($settings['meta']['entity_path'], $settings['meta']['auto_generate_proxies'], $settings['meta']['proxy_dir'], $settings['meta']['cache'], false);

$em = \Doctrine\ORM\EntityManager::create($settings['connection'], $config);

return ConsoleRunner::createHelperSet($em);
