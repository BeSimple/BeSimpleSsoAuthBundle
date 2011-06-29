<?php

namespace BeSimple\SsoAuthBundle\Sso\Cas;

use BeSimple\SsoAuthBundle\Sso\AbstractSsoProvider;
use BeSimple\SsoAuthBundle\Sso\SsoProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Buzz\Browser;

class CasProvider extends AbstractSsoProvider implements SsoProviderInterface
{
    public function __construct(Browser $browser)
    {
        $this->browser = $browser;
        $this->server  = null;
    }

    public function configure($baseUrl, $checkUrl, $version = 1)
    {
        $this->server = new CasServer($this->browser, $baseUrl, $checkUrl, $version);

        return $this;
    }

    public function getProtocolName()
    {
        return 'cas';
    }

    protected function findCredentials(Request $request)
    {
        return $request->query->get('ticket', null);
    }
}
