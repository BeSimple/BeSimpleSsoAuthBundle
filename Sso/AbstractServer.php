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
        return $this->getConfigValue('login_url');
    }

    /**
     * {@inheritdoc}
     */
    public function getLogoutUrl()
    {
        return $this->getConfigValue('logout_url');
    }

    /**
     * {@inheritdoc}
     */
    public function getLogoutTarget()
    {
        return $this->getConfigValue('logout_target');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationUrl()
    {
        return $this->getConfigValue('validation_url');
    }

    /**
     * {@inheritdoc}
     */
    public function getCheckUrl()
    {
        return $this->getConfigValue('check_url');
    }
}
