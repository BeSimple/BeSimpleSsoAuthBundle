<?php

namespace BeSimple\SsoAuthBundle\Tests\Functional\Cas;

use BeSimple\SsoAuthBundle\Tests\Functional\WebTestCase;
use Symfony\Component\HttpKernel\Util\Filesystem;
use Symfony\Bundle\FrameworkBundle\Client;
use BeSimple\SsoAuthBundle\Tests\AppKernel;
use BeSimple\SsoAuthBundle\Tests\Conroller\TestController;

abstract class CasWebTestCase extends WebTestCase
{
    static protected function createKernel(array $options = array())
    {
        return parent::createKernel('cas', $options);
    }
}