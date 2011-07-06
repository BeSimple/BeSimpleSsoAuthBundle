<?php

namespace BeSimple\SsoAuthBundle\Sso;

use Buzz\Client\ClientInterface;
use Buzz\Message\Request;

abstract class AbstractSsoServer
{
    protected $validationClient;
    protected $validationMethod;
    protected $baseUrl;
    protected $checkUrl;
    protected $version;
    protected $usernameFormat;

    public function __construct()
    {
        $this->validationClient = null;
        $this->validationMethod = Request::METHOD_GET;
        $this->baseUrl  = null;
        $this->checkUrl = null;
        $this->version  = 1;
    }

    public function getId()
    {
        return $this->baseUrl;
    }

    public function getValidationClient()
    {
        return $this->validationClient;
    }

    public function setValidationClient(ClientInterface $client)
    {
        $this->validationClient = $client;

        return $this;
    }

    public function getValidationMethod()
    {
        return $this->validationMethod;
    }

    public function setValidationMethod($validationMethod)
    {
        $this->validationMethod = strtoupper($validationMethod);

        return $this;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    public function getCheckUrl()
    {
        return $this->checkUrl;
    }

    public function setCheckUrl($checkUrl)
    {
        $this->checkUrl = $checkUrl;

        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function getUsernameFormat()
    {
        return $this->usernameFormat;
    }

    public function setUsernameFormat($usernameFormat)
    {
        $this->usernameFormat = $usernameFormat;

        return $this;
    }
}
