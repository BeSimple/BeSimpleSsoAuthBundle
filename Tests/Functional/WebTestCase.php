<?php

namespace BeSimple\SsoAuthBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\HttpKernel\Util\Filesystem;
use Symfony\Bundle\FrameworkBundle\Client;
use BeSimple\SsoAuthBundle\Tests\AppKernel;
use BeSimple\SsoAuthBundle\Tests\Controller\TestController;
use BeSimple\SsoAuthBundle\Tests\Controller\TrustedSsoController;

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
        $this->assertEquals(
            $true ? TestController::ANON_RESPONSE : TrustedSsoController::LOGIN_REQUIRED_RESPONSE,
            $client->request('GET', '/anon')->text()
        );
    }

    protected function assertSecured(Client $client, $true = true)
    {
        $this->assertEquals(
            $true ? TestController::SECURED_RESPONSE : TrustedSsoController::LOGIN_REQUIRED_RESPONSE,
            $client->request('GET', '/secured')->text()
        );
    }

    protected function assertUser(Client $client, $true = true)
    {
        $this->assertEquals(
            $true ? TestController::USER_RESPONSE : TrustedSsoController::LOGIN_REQUIRED_RESPONSE,
            $client->request('GET', '/secured/user')->text()
        );
    }

    protected function assertAdmin(Client $client, $true = true)
    {
        $this->assertEquals(
            $true ? TestController::ADMIN_RESPONSE : TrustedSsoController::LOGIN_REQUIRED_RESPONSE,
            $client->request('GET', '/secured/admin')->text()
        );
    }
}
