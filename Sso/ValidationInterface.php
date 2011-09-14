<?php

namespace BeSimple\SsoAuthBundle\Sso;

interface ValidationInterface
{
    public function isSuccess();
    public function getUsername();
    public function getAttributes();
}
