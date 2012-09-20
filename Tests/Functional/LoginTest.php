<?php

namespace BeSimple\SsoAuthBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Client;
use BeSimple\SsoAuthBundle\Tests\Controller\TestController;
use BeSimple\SsoAuthBundle\Tests\Controller\TrustedSsoController;
use BeSimple\SsoAuthBundle\Tests\Controller\Server\Controller as ServerController;

class LoginTest extends WebTestCase
{
    /**
     * @dataProvider provideLoginData
     */
    public function testLogin($clientName, $securedUrl, $login, $expectedMessage)
    {
        $client = $this->createSsoClient($clientName);
        // client follow redirects
        $client->followRedirects();

        // go to secured page -> got login required
        $crawler = $client->request('GET', $securedUrl);
        $this->assertEquals(TrustedSsoController::LOGIN_REQUIRED_MESSAGE, $crawler->filter('#message')->text());

        // click link -> got login form
        $crawler = $client->click($crawler->filter('#url')->link());
        $this->assertEquals('login', $crawler->filter('form')->attr('id'));

        // fill form & submit -> got expected message
        $form    = $crawler->filter('input[type=submit]')->form();
        $crawler = $client->submit($form, array('login[username]' => $login, 'login[password]' => $login));
        $this->assertEquals($expectedMessage, $crawler->filter('#message')->text());

        if (!$login === self::LOGIN_INVALID) {
            // check validation attributes
            $attrs = static::$kernel->getContainer()->get('security.context')->getToken()->getValidationAttributes();
            $this->assertEquals(array('attr1' => 'val1', 'attr2' => 'val2'), $attrs);
        }

        // logout -> got logout redirect
        $crawler = $client->request('GET', '/secured/logout');
        $this->assertEquals(TrustedSsoController::LOGOUT_REDIRECT_MESSAGE, $crawler->filter('#message')->text());

        // click link -> got logout done
        $crawler = $client->click($crawler->filter('#url')->link());
        $this->assertEquals(ServerController::LOGOUT_MESSAGE, $crawler->filter('#message')->text());

        // click link -> go to homepage
        $crawler = $client->click($crawler->filter('#url')->link());
        $this->assertEquals(TestController::HOME_MESSAGE, $crawler->filter('#message')->text());
    }

    public function provideLoginData()
    {
        $data = array();
        foreach ($this->provideClients() as $client) {
            foreach ($this->provideCases() as $case) {
                $data[] = array_merge($client, $case);
            }
        }

        return $data;
    }

    private function provideCases()
    {
        return array(
            array('/secured',       self::LOGIN_USER,    TestController::SECURED_MESSAGE),
            array('/secured',       self::LOGIN_INVALID, TestController::LOGIN_MESSAGE),
            array('/secured/user',  self::LOGIN_USER,    TestController::USER_MESSAGE),
            array('/secured/admin', self::LOGIN_ADMIN,   TestController::ADMIN_MESSAGE),
            array('/secured/admin', self::LOGIN_USER,    TestController::FORBIDDEN_MESSAGE)
        );
    }
}
