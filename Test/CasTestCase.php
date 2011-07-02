<?php

namespace BeSimple\SsoAuthBundle\Test;

use BeSimple\SsoAuthBundle\Sso\Cas\CasProvider;
use BeSimple\SsoAuthBundle\Sso\Cas\CasServer;
use BeSimple\SsoAuthBundle\Sso\Cas\CasV1Validation;
use BeSimple\SsoAuthBundle\Sso\Cas\CasV2Validation;

abstract class CasTestCase extends TestCase
{
    const VERSION1 = 1;
    const VERSION2 = 2;

    const ATTRIBUTES_NONE   = 0;
    const ATTRIBUTES_STYLE1 = 1;
    const ATTRIBUTES_STYLE2 = 2;

    public function provideProviders()
    {
        return array(
            array($this->createProvider(1, $this->baseUrl, $this->checkUrl)),
            array($this->createProvider(2, $this->baseUrl, $this->checkUrl)),
        );
    }

    public function provideServers()
    {
        return array(
            array($this->createServer(1, $this->baseUrl, $this->checkUrl)),
            array($this->createServer(2, $this->baseUrl, $this->checkUrl)),
        );
    }

    protected function createProvider($version, $baseUrl, $checkUrl)
    {
        return parent::createProvider(new CasProvider(), $version, $baseUrl, $checkUrl);
    }

    protected function createServer($version, $baseUrl, $checkUrl)
    {
        return parent::createServer(new CasServer(), $version, $baseUrl, $checkUrl);
    }

    protected function createValidation($version, $content)
    {
        return parent::createValidation($version === self::VERSION2 ? new CasV2Validation() : new CasV1Validation(), $content);
    }
}
