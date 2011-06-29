<?php

namespace BeSimple\SsoAuthBundle\Sso;

interface SsoValidationInterface
{
    public function isSuccess();
    public function getUsername();
    public function getAttributes();
}
