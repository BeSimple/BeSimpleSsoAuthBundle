<?php

namespace BeSimple\SsoAuthBundle\Security\Http\Logout;

use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SsoLogoutHandler implements LogoutHandlerInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @param TokenInterface $token
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        if ($token instanceof SsoToken) {
            $token->getSsoProvider()->processLogout();
        }
    }
}
