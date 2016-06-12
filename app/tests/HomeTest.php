<?php
namespace Skeleton\Tests;

use Skeleton\Tests\IntegrationTestCase;

class HomeTest extends IntegrationTestCase
{

    public function testHomePage()
    {
        $res = $this->call('GET', '/');
        $this->assertSame('1.1', $res->getProtocolVersion());
        $this->assertSame(200, $res->getStatusCode());
        $this->assertSame('text/html; charset=UTF-8', $res->getHeaderLine('Content-Type'));
    }
}
