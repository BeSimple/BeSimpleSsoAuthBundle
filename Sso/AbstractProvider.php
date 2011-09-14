<?php

namespace BeSimple\SsoAuthBundle\Sso;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Buzz\Message\Response;
use BeSimple\SsoAuthBundle\Security\Core\Authentication\Token\SsoToken;

abstract class AbstractProvider
{
    /**
     * @var ServerInterface
     */
    protected $server;

    /**
     * @return ServerInterface
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param string $username
     *
     * @return string
     */
    public function formatUsername($username)
    {
        $placeholders = array(
            '{username}'  => $username,
            '{server_id}' => $this->server->getId(),
        );

        return strtr($this->server->getUsernameFormat(), $placeholders);
    }

    /**
     * @return RedirectResponse
     */
    public function handleLogin()
    {
        return new RedirectResponse($this->server->getLoginUrl());
    }

    /**
     * @return RedirectResponse
     */
    public function handleLogout()
    {
        return new RedirectResponse($this->server->getLogoutUrl());
    }

    /**
     * @param $credentials
     * @return ValidationInterface
     */
    public function validateCredentials($credentials)
    {
        return $this->server->getValidation($credentials);
    }

    /**
     * @param SsoToken $token
     */
    public function processLogout(SsoToken $token)
    {
        return;
    }
}
