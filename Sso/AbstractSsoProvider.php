<?php

namespace BeSimple\SsoAuthBundle\Sso;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Buzz\Message\Response;
use BeSimple\SsoAuthBundle\Security\Core\Authentication\Token\SsoToken;

abstract class AbstractSsoProvider
{
    protected $server;

    public function getServer()
    {
        return $this->server;
    }

    public function formatUsername($username)
    {
        $placeholders = array(
            '{username}'  => $username,
            '{server_id}' => $this->server->getId(),
        );

        return strtr($this->server->getUsernameFormat(), $placeholders);
    }

    public function handleLogin()
    {
        return new RedirectResponse($this->server->getLoginUrl());
    }

    public function handleLogout()
    {
        return new RedirectResponse($this->server->getLogoutUrl());
    }

    public function validateCredentials($credentials)
    {
        return $this->server->getValidation($credentials);
    }

    public function processLogout()
    {
        return;
    }
}
