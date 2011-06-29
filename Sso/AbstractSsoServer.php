<?php

namespace BeSimple\SsoAuthBundle\Sso;

use Buzz\Browser;

abstract class AbstractSsoServer
{
    protected $browser;
    protected $baseUrl;
    protected $checkUrl;
    protected $version;

    public function __construct(Browser $browser, $baseUrl, $checkUrl, $version = 1)
    {
        $this->browser  = $browser;
        $this->baseUrl  = $baseUrl;
        $this->checkUrl = $checkUrl;
        $this->version  = $version;
    }

    public function getId()
    {
        return $this->baseUrl;
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function setCheckUrl($checkUrl)
    {
        $this->checkUrl = $checkUrl;
    }

    public function getCheckUrl()
    {
        return $this->checkUrl;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getVersion()
    {
        return $this->version;
    }
}
