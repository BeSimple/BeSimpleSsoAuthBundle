<?php

namespace BeSimple\SsoAuthBundle\Tests\Form;

class Login
{
    public $username;
    public $password;

    public function isValid()
    {
        return strlen($this->username) > 0 && $this->username === $this->password;
    }

    public function getCredentials()
    {
        return $this->isValid() ? $this->username : null;
    }
}
