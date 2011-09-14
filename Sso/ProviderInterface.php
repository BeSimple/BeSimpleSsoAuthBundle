<?php

namespace BeSimple\SsoAuthBundle\Sso;

use BeSimple\SsoAuthBundle\Security\Core\Authentication\Token\SsoToken;
use Symfony\Component\HttpFoundation\Request;

interface ProviderInterface
{
    public function handleLogin();
    public function handleLogout();
    public function processLogout(SsoToken $token);
    public function formatUsername($username);
    public function isValidationRequest(Request $request);
    public function createToken(Request $request);
    public function validateCredentials($credentials);
}
