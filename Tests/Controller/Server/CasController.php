<?php

namespace BeSimple\SsoAuthBundle\Tests\Controller\Server;

use Symfony\Component\HttpFoundation\Request;
use BeSimple\SsoAuthBundle\Tests\Form\Login;

class CasController extends Controller
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param Login $login
     * @return string
     */
    protected function getLoginRedirectUrl(Request $request, Login $login)
    {
        $url = urldecode($request->query->get('service'));

        return sprintf('%s?ticket=%s', $url, $login->getCredentials());
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    protected function getLogoutRedirectUrl(Request $request)
    {
        if ($request->query->has('url')) {
            return urldecode($request->query->get('url'));
        }

        return urldecode($request->query->get('service'));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    protected function getCredentials(Request $request)
    {
        return $request->query->get('ticket');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $name
     * @return string
     */
    protected function getValidationView(Request $request, $name)
    {
        return 2 === (int) $request->attributes->get('version')
            ? sprintf('cas/%s_v2.xml.twig', $name)
            : sprintf('cas/%s_v1.txt.twig', $name);
    }
}
