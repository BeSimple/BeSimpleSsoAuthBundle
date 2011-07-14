<?php

namespace BeSimple\SsoAuthBundle\Controller;

use Symfony\Component\HttpKernel\Exception\HttpException;

class OpenSsoController extends Controller
{
    public function loginAction()
    {
        throw new HttpException(500, 'Not implemented.');
    }

    public function logoutAction()
    {
        throw new HttpException(500, 'Not implemented.');
    }
}