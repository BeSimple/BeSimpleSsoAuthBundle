<?php

namespace BeSimple\SsoAuthBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

class OpenSsoController
{
    public function loginAction()
    {
        throw new HttpException(500, 'Method not implemented.');
    }
}