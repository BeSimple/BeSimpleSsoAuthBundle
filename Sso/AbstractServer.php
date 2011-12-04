<?php

namespace BeSimple\SsoAuthBundle\Sso;

use Buzz\Client\ClientInterface;
use Buzz\Message\Request;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractServer extends AbstractComponent
{
    /**
     * @return string
     */
    public function getLoginUrl()
    {
        return $this->config['login_url'];
    }

    /**
     * @return string
     */
    public function getLogoutUrl()
    {
        return $this->config['logout_url'];
    }

    /**
     * @return string
     */
    public function getValidationUrl()
    {
        return $this->config['validation_url'];
    }

    /**
     * @return string
     */
    public function getCheckUrl()
    {
        return $this->config['check_url'];
    }
}
