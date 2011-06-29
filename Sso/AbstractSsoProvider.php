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
        return sprintf('%s@%s', $username, $this->server->getId());
    }

    public function handleLogin()
    {
        return new RedirectResponse($this->server->getLoginUrl());
    }

    public function isValidationRequest(Request $request)
    {
        return !is_null($this->findCredentials($request));
    }

    public function createToken(Request $request)
    {
        return new SsoToken($this, $this->findCredentials($request));
    }

    public function validateCredentials($credentials)
    {
        return $this->server->getValidation($credentials);
    }

    public function processLogout()
    {
        return;
    }

    abstract protected function findCredentials(Request $request);
}
