<?php

namespace BeSimple\SsoAuthBundle\Tests\Unit\Cas;

use BeSimple\SsoAuthBundle\Sso\Cas\CasServer;
use Buzz\Client\FileGetContents;

class CasServerTest extends CasTestCase
{
    /**
     * @dataProvider provideServers
     */
    public function testUrlGetters(CasServer $server)
    {
        $this->assertEquals(sprintf('%s/login?service=%s', $this->baseUrl, urlencode($this->returnUrl)), $server->getLoginUrl());
        $this->assertEquals(sprintf('%s/logout?service=%s', $this->baseUrl, urlencode($this->returnUrl)), $server->getLogoutUrl());
    }

    /**
     * @dataProvider provideBaseUrlId
     */
    public function testIdGetter($baseUrl, $expectedId)
    {
        $server = new CasServer();
        $server->setBaseUrl($baseUrl);

        $this->assertEquals($expectedId, $server->getId());
    }

    public function provideBaseUrlId()
    {
        return array(
            array('http://cas.server/path?param=value', 'cas.server/path'),
            array('http://cas.server/?param=value',     'cas.server'),
            array('http://cas.server',                  'cas.server'),
            array('/path?param=value',                  'localhost/path'),
        );
    }
}