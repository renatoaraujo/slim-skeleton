<?php
date_default_timezone_set('America/Sao_Paulo');

defined('APPPATH') || define('APPPATH', dirname(__DIR__));
defined('ROOTPATH') || define('ROOTPATH', dirname(APPPATH));

$loader = require ROOTPATH . '/vendor/autoload.php';
$loader->addPsr4('Skeleton\Tests\\', __DIR__);