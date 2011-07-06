<?php

namespace BeSimple\SsoAuthBundle\Tests\Functional\Cas;

class BaseCasWebTestCase extends CasWebTestCase
{
    public function testAnon()
    {
        $this->assertAnon(static::createClient());
    }

    public function testSecured()
    {
        $this->assertSecured(static::createClient(), false);
    }

    public function testUser()
    {
        $this->assertUser(static::createClient(), false);
    }

    public function testAdmin()
    {
        $this->assertAdmin(static::createClient(), false);
    }
}
