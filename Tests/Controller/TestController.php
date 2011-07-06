<?php

namespace BeSimple\SsoAuthBundle\Tests\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
 
class TestController extends ContainerAware
{
    const ANON_RESPONSE    = 'hello anon';
    const SECURED_RESPONSE = 'hello secured';
    const USER_RESPONSE    = 'hello user';
    const ADMIN_RESPONSE   = 'hello admin';

    public function anonAction()
    {
        return new Response(self::ANON_RESPONSE);
    }

    public function securedAction()
    {
        return new Response(self::SECURED_RESPONSE);
    }

    public function userAction()
    {
        return new Response(self::USER_RESPONSE);
    }

    public function adminAction()
    {
        return new Response(self::ADMIN_RESPONSE);
    }
}