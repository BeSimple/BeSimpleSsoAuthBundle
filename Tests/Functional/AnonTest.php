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
    public function testAnon(Client $client)
    {
        $this->processTest($client, '/anon', TestController::ANON_MESSAGE);
    }

    /**
     * @dataProvider provideClients
     */
    public function testSecured(Client $client)
    {
        $this->processTest($client, '/secured', TrustedSsoController::LOGIN_REQUIRED_MESSAGE);
    }

    /**
     * @dataProvider provideClients
     */
    public function testUser(Client $client)
    {
        $this->processTest($client, '/secured/user', TrustedSsoController::LOGIN_REQUIRED_MESSAGE);
    }

    /**
     * @dataProvider provideClients
     */
    public function testAdmin(Client $client)
    {
        $this->processTest($client, '/secured/admin', TrustedSsoController::LOGIN_REQUIRED_MESSAGE);
    }

    private function processTest(Client $client, $url, $expectedMessage)
    {
        $crawler = $client->request('GET', $url);
        $message = $crawler->filter('#message')->text();
        $this->assertEquals($expectedMessage, $message);
    }
}
