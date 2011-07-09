<?php

namespace BeSimple\SsoAuthBundle\Tests\Controller;

class TestController extends Controller
{
    const ANON_MESSAGE    = 'hello anon';
    const SECURED_MESSAGE = 'hello secured';
    const USER_MESSAGE    = 'hello user';
    const ADMIN_MESSAGE   = 'hello admin';

    public function anonAction()
    {
        return $this->renderMessage(self::ANON_MESSAGE);
    }

    public function securedAction()
    {
        return $this->renderMessage(self::SECURED_MESSAGE);
    }

    public function userAction()
    {
        return $this->renderMessage(self::USER_MESSAGE);
    }

    public function adminAction()
    {
        return $this->renderMessage(self::ADMIN_MESSAGE);
    }

    private function renderMessage($message)
    {
        return $this->render('common/message.html.twig', array('message' => $message));
    }
}