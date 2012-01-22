<?php

namespace BeSimple\SsoAuthBundle\Sso;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Buzz\Message\Response;
use BeSimple\SsoAuthBundle\Security\Core\Authentication\Token\SsoToken;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractProtocol extends AbstractComponent implements ProtocolInterface
{
    /**
     * {@inheritdoc}
     */
    public function processLogout(SsoToken $token)
    {
        // does nothing most of the case
    }
}
