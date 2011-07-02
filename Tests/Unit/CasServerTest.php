<?php

namespace BeSimple\SsoAuthBundle\Tests;

use BeSimple\SsoAuthBundle\Test\CasTestCase;
use BeSimple\SsoAuthBundle\Sso\Cas\CasServer;
use Buzz\Client\FileGetContents;

class CasServerTest extends CasTestCase
{
    /**
     * @dataProvider provideServers
     */
    public function testGetters(CasServer $server)
    {
        $this->assertEquals(sprintf('%s/login?service=%s', $this->baseUrl, urlencode($this->checkUrl)), $server->getLoginUrl());
        $this->assertEquals(sprintf('%s/logout?service=%s', $this->baseUrl, urlencode($this->checkUrl)), $server->getLogoutUrl());
        $this->assertEquals($this->baseUrl, $server->getId());
    }
}