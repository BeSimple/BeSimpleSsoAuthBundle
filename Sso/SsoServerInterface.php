<?php

namespace BeSimple\SsoAuthBundle\Sso;

interface SsoServerInterface
{
    public function getId();
    public function getLoginUrl();
    public function getValidation($credentials);
}
