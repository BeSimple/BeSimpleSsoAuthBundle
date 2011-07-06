<?php

namespace BeSimple\SsoAuthBundle\Tests\Conroller\Server;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\TemplateReference;
use BeSimple\SsoAuthBundle\Tests\Form\Login;
use BeSimple\SsoAuthBundle\Tests\Form\LoginType;

class CasController extends Controller
{
    /**
     * @abstract
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $credentials
     * @return string
     */
    protected function getLoginRedirectUrl(Request $request, Login $login)
    {
        $url = urldecode($request->query->get('service'));

        return sprintf('%s?ticket=%s', $url, $login->getCredentials());
    }

    /**
     * @abstract
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    protected function getViewDirectory(Request $request)
    {
        $version = $request->attributes->get('version');

        return sprintf('cas_%s', $version);
    }
}