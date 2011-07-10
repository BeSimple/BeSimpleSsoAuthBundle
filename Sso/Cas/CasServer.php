<?php

namespace BeSimple\SsoAuthBundle\Sso\Cas;

use BeSimple\SsoAuthBundle\Sso\AbstractSsoServer;
use BeSimple\SsoAuthBundle\Sso\SsoServerInterface;
use Buzz\Message\Request;
use Buzz\Message\Response;

class CasServer extends AbstractSsoServer implements SsoServerInterface
{
    public function getLoginUrl()
    {
        return sprintf('%s/login?service=%s', $this->baseUrl, urlencode($this->checkUrl));
    }

    public function getLogoutUrl()
    {
        return sprintf('%s/logout?service=%s', $this->baseUrl, urlencode($this->checkUrl));
    }

    public function getValidation($credentials)
    {
        $actions    = array(1 => 'validation', 2 => 'serviceValidation');
        $validation = sprintf('%s\\CasV%sValidation', __NAMESPACE__, $this->version);
        $request    = new Request($this->validationMethod);
        $response   = new Response();

        $request->fromUrl(sprintf(
            '%s/%s?service=%s&ticket=%s',
            $this->baseUrl,
            $actions[$this->version],
            urlencode($this->checkUrl),
            $credentials
        ));

        $this->validationClient->send($request, $response);

        return new $validation($response);
    }
}
