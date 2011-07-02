<?php

namespace BeSimple\SsoAuthBundle\Test;

use BeSimple\SsoAuthBundle\Sso\Cas\CasProvider;
use BeSimple\SsoAuthBundle\Sso\Cas\CasServer;
use BeSimple\SsoAuthBundle\Sso\Cas\CasV1Validation;
use BeSimple\SsoAuthBundle\Sso\Cas\CasV2Validation;

abstract class CasTestCase extends TestCase
{
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
        return parent::createValidation($version === 2 ? new CasV2Validation() : new CasV1Validation(), $content);
    }
}
