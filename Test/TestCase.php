<?php

namespace BeSimple\SsoAuthBundle\Test;

use BeSimple\SsoAuthBundle\Sso\SsoProviderInterface;
use BeSimple\SsoAuthBundle\Sso\SsoServerInterface;
use BeSimple\SsoAuthBundle\Sso\SsoValidationInterface;
use Buzz\Message\Response;
use Buzz\Client\FileGetContents;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $baseUrl      = 'http://sso.server';
    protected $checkUrl     = 'http://my.project/check';
    protected $errorMessage = 'error message';
    protected $username     = 'username';
    protected $credentials  = 'credentials';
    protected $attributes   = array('name1' => 'value1', 'name2' => 'value2');

    abstract public function provideServers();

    protected function createProvider(SsoProviderInterface $provider, $version, $baseUrl, $checkUrl)
    {
        $this->configureServer($provider->getServer(), $version, $baseUrl, $checkUrl);

        return $provider;
    }

    protected function createServer(SsoServerInterface $server, $version, $baseUrl, $checkUrl)
    {
        $this->configureServer($server, $version, $baseUrl, $checkUrl);

        return $server;
    }

    protected function createValidation(SsoValidationInterface $validation, $content)
    {
        $response = new Response();
        $response->setContent($content);

        return $validation->setResponse($response);
    }

    private function configureServer(SsoServerInterface $server, $version, $baseUrl, $checkUrl)
    {
        $server
            ->setBaseUrl($baseUrl)
            ->setCheckUrl($checkUrl)
            ->setValidationClient(new FileGetContents())
            ->setValidationMethod('get')
            ->setVersion($version)
        ;
    }
}
