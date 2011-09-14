<?php

namespace BeSimple\SsoAuthBundle\Sso\Cas;

use BeSimple\SsoAuthBundle\Sso\AbstractServer;
use BeSimple\SsoAuthBundle\Sso\ServerInterface;
use Buzz\Message\Request;
use Buzz\Message\Response;

class CasServer extends AbstractServer implements ServerInterface
{
    public function getLoginUrl()
    {
        return sprintf('%s/login?service=%s', $this->baseUrl, urlencode($this->returnUrl));
    }

    public function getLogoutUrl()
    {
        return sprintf('%s/logout?service=%s', $this->baseUrl, urlencode($this->returnUrl));
    }

    public function getValidation($credentials)
    {
        $actions    = array(1 => 'validate', 2 => 'serviceValidate');
        $validation = sprintf('%s\\CasV%sValidation', __NAMESPACE__, $this->version);
        $request    = new Request($this->validationMethod);
        $response   = new Response();

        $request->fromUrl(sprintf(
            '%s/%s?service=%s&ticket=%s',
            $this->baseUrl,
            $actions[$this->version],
            urlencode($this->returnUrl),
            $credentials
        ));

        $this->validationClient->send($request, $response);

        return new $validation($response);
    }
}
