<?php

namespace BeSimple\SsoAuthBundle\Sso\Cas;

use BeSimple\SsoAuthBundle\Sso\AbstractSsoProvider;
use BeSimple\SsoAuthBundle\Sso\SsoProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Buzz\Browser;

class CasProvider extends AbstractSsoProvider implements SsoProviderInterface
{
    protected function findCredentials(Request $request)
    {
        return $request->query->get('ticket', null);
    }
}
