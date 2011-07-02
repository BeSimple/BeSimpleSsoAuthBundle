<?php

namespace BeSimple\SsoAuthBundle\Tests;

use BeSimple\SsoAuthBundle\Sso\Cas\CasServer;
use Buzz\Client\FileGetContents;

class CasServerTest extends TestCase
{
    private $baseUrl  = 'http://cas.server';
    private $checkUrl = 'http://my.project/check';

    /**
     * @dataProvider provideServers
     */
    public function testGetters(CasServer $server)
    {
        $this->assertEquals(sprintf('%s/login?service=%s', $this->baseUrl, urlencode($this->checkUrl)), $server->getLoginUrl());
        $this->assertEquals(sprintf('%s/logout?service=%s', $this->baseUrl, urlencode($this->checkUrl)), $server->getLogoutUrl());
        $this->assertEquals($this->baseUrl, $server->getId());
    }

    public function provideServers()
    {
        return array(
            array($this->createServer(1, $this->baseUrl, $this->checkUrl)),
            array($this->createServer(2, $this->baseUrl, $this->checkUrl)),
        );
    }

    private function createServer($version, $baseUrl, $checkUrl)
    {
        $server = new CasServer();
        $client = new FileGetContents();

        $server
            ->setBaseUrl($baseUrl)
            ->setCheckUrl($checkUrl)
            ->setValidationClient($client)
            ->setValidationMethod('get')
            ->setVersion($version)
        ;

        return $server;
    }
}