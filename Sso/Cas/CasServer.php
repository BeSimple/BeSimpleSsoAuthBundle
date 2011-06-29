<?php

namespace BeSimple\SsoAuthBundle\Sso\Cas;

use BeSimple\SsoAuthBundle\Sso\AbstractSsoServer;
use BeSimple\SsoAuthBundle\Sso\SsoServerInterface;
use Buzz\Message\Response;

class CasServer extends AbstractSsoServer implements SsoServerInterface
{
    public function getLoginUrl()
    {
        return sprintf('http://%s/login?service=%s', $this->baseUrl, urlencode($this->checkUrl));
    }

    public function getLogoutUrl()
    {
        return sprintf('http://%s/logout?service=%s', $this->baseUrl, urlencode($this->checkUrl));
    }

    public function getValidation($credentials)
    {
        $actions = array(1 => 'validation', 2 => 'serviceValidation');
        $url     = sprintf('%s/%s?service=%s&ticket=%s', $this->baseUrl, $actions[$this->version], urlencode($this->checkUrl), $credentials);
        $class   = sprintf('Cas%sValidation', $this->version);

        return new $class($this->browser->get($url));
    }
}
