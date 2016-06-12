<?php

namespace Skeleton\Tests;

use Slim\App;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Slim\App
     */
    protected $app;

    /**
     * Setting up
     */
    protected function setUp()
    {
        if (null === $this->app) {
            $this->app = require APPPATH . '/config/bootstrap.php';
        }
        parent::setUp();
    }

    /**
     * Tear down
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}
