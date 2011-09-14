<?php

namespace BeSimple\SsoAuthBundle\Sso;

interface ServerInterface
{
    public function getId();
    public function getLoginUrl();
    public function getLogoutUrl();
    public function getUsernameFormat();
    public function getValidation($credentials);
}
