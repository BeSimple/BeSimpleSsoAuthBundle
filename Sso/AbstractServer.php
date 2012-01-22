<?php

namespace BeSimple\SsoAuthBundle\Sso;

use Buzz\Client\ClientInterface;
use Buzz\Message\Request;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractServer extends AbstractComponent implements ServerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getLoginUrl()
    {
        return $this->config['login_url'];
    }

    /**
     * {@inheritdoc}
     */
    public function getLogoutUrl()
    {
        return $this->config['logout_url'];
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationUrl()
    {
        return $this->config['validation_url'];
    }

    /**
     * {@inheritdoc}
     */
    public function getCheckUrl()
    {
        return $this->config['check_url'];
    }
}
