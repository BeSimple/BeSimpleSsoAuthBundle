<?php

namespace BeSimple\SsoAuthBundle\Sso\Cas;

use BeSimple\SsoAuthBundle\Sso\AbstractProvider;
use BeSimple\SsoAuthBundle\Sso\ProviderInterface;
use BeSimple\SsoAuthBundle\Security\Core\Authentication\Token\SsoToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Buzz\Browser;

class CasProvider extends AbstractProvider implements ProviderInterface
{
    const CREDENTIALS_QUERY_KEY = 'ticket';

    public function __construct()
    {
        $this->server = new CasServer();
    }

    public function isValidationRequest(Request $request)
    {
        return $request->query->has(self::CREDENTIALS_QUERY_KEY);
    }

    public function createToken(Request $request)
    {
        return new SsoToken($this, $request->query->get(self::CREDENTIALS_QUERY_KEY));
    }
}
