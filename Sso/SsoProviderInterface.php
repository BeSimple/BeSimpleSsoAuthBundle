<?php

namespace BeSimple\SsoAuthBundle\Sso;

use Symfony\Component\HttpFoundation\Request;

interface SsoProviderInterface
{
    public function configure($baseUrl, $checkUrl, $version = 1);
    public function handleLogin();
    public function formatUsername($username);
    public function isValidationRequest(Request $request);
    public function createToken(Request $request);
    public function validateCredentials($credentials);
    public function processLogout();
    public function getProtocolName();
}
