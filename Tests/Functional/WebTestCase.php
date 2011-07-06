<?php

namespace BeSimple\SsoAuthBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\HttpKernel\Util\Filesystem;
use Symfony\Bundle\FrameworkBundle\Client;
use BeSimple\SsoAuthBundle\Tests\AppKernel;
use BeSimple\SsoAuthBundle\Tests\Controller\TestController;

abstract class WebTestCase extends BaseWebTestCase
{
    static protected $tmpPath;
    static protected $configFile;

    static protected function createKernel($name, array $options = array())
    {
        static::$tmpPath    = sys_get_temp_dir().'/be_simple_sso_auth_bundle_tests';
        static::$configFile = __DIR__.'/../Resources/config/'.$name.'.yml';

        return new AppKernel(
            static::$tmpPath,
            static::$configFile,
            isset($options['environment']) ? $options['environment'] : 'test',
            isset($options['debug']) ? $options['debug'] : true
        );
    }

    protected function deleteTmpDir($testCase)
    {
        if (!file_exists(static::$tmpPath)) {
            return;
        }

        $fs = new Filesystem();
        $fs->remove(static::$tmpPath);
    }

    protected function assertAnon(Client $client, $true = true)
    {
        $this->assertResponseText($client, '/anon', TestController::ANON_RESPONSE, $true);
    }

    protected function assertSecured(Client $client, $true = true)
    {
        $this->assertResponseText($client, '/secured', TestController::SECURED_RESPONSE, $true);
    }

    protected function assertUser(Client $client, $true = true)
    {
        $this->assertResponseText($client, '/secured/user', TestController::USER_RESPONSE, $true);
    }

    protected function assertAdmin(Client $client, $true = true)
    {
        $this->assertResponseText($client, '/secured/admin', TestController::ADMIN_RESPONSE, $true);
    }

    protected function assertResponseText(Client $client, $url, $expected, $true = true)
    {
        $crawler = $client->request('GET', $url);
        $content = $crawler->text();
        $assert  = $true ? 'assertTrue' : 'assertFalse';

        $this->$assert($content === $expected);
    }
}
