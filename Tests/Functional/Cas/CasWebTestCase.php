<?php

namespace BeSimple\SsoAuthBundle\Tests\Functional\Cas;

use BeSimple\SsoAuthBundle\Tests\Functional\WebTestCase;

abstract class CasWebTestCase extends WebTestCase
{
    static protected function createKernel(array $options = array())
    {
        return parent::createKernel('cas', $options);
    }
}