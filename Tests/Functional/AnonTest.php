<?php

namespace BeSimple\SsoAuthBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Client;
use BeSimple\SsoAuthBundle\Tests\Functional\WebTestCase;
use BeSimple\SsoAuthBundle\Tests\Controller\TestController;
use BeSimple\SsoAuthBundle\Tests\Controller\TrustedSsoController;

class AnonTest extends WebTestCase
{
    /**
     * @dataProvider provideClients
     */
    public function testAnon($clientName)
    {
        $this->processTest($clientName, '/anon', TestController::ANON_MESSAGE);
    }

    /**
     * @dataProvider provideClients
     */
    public function testSecured($clientName)
    {
        $this->processTest($clientName, '/secured', TrustedSsoController::LOGIN_REQUIRED_MESSAGE);
    }

    /**
     * @dataProvider provideClients
     */
    public function testUser($clientName)
    {
        $this->processTest($clientName, '/secured/user', TrustedSsoController::LOGIN_REQUIRED_MESSAGE);
    }

    /**
     * @dataProvider provideClients
     */
    public function testAdmin($clientName)
    {
        $this->processTest($clientName, '/secured/admin', TrustedSsoController::LOGIN_REQUIRED_MESSAGE);
    }

    private function processTest($clientName, $url, $expectedMessage)
    {
        $client = $this->createSsoClient($clientName);
        $crawler = $client->request('GET', $url);
        $message = $crawler->filter('#message')->text();
        $this->assertEquals($expectedMessage, $message);
    }
}
