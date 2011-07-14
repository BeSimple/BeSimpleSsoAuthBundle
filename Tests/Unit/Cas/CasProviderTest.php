<?php

namespace BeSimple\SsoAuthBundle\Tests\Unit\Cas;

use BeSimple\SsoAuthBundle\Sso\Cas\CasProvider;
use BeSimple\SsoAuthBundle\Security\Core\Authentication\Token\SsoToken;
use Buzz\Client\FileGetContents;
use Symfony\Component\HttpFoundation\Request;

class CasProviderTest extends CasTestCase
{
    /**
     * @dataProvider provideProviders
     */
    public function testIsNotValidationRequest(CasProvider $provider)
    {
        $this->assertFalse($provider->isValidationRequest(new Request()));
    }

    /**
     * @dataProvider provideProviders
     */
    public function testIsValidationRequest(CasProvider $provider)
    {
        $query = array(CasProvider::CREDENTIALS_QUERY_KEY => $this->credentials);
        $this->assertTrue($provider->isValidationRequest(new Request($query)));
    }

    /**
     * @dataProvider provideProviders
     */
    public function testCreateToken(CasProvider $provider)
    {
        $query = array(CasProvider::CREDENTIALS_QUERY_KEY => $this->credentials);
        $token = $provider->createToken(new Request($query));

        $this->assertTrue($token instanceof SsoToken);
        $this->assertFalse($token->isAuthenticated());
        $this->assertEquals($this->credentials, $token->getCredentials());
        $this->assertEquals($provider, $token->getSsoProvider());
        $this->assertEquals(null, $token->getUsername());
        $this->assertEquals(null, $token->getUser());
        $this->assertEquals(array(), $token->getRoles());
        $this->assertEquals(array(), $token->getAttributes());
    }
}