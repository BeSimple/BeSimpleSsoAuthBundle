<?php

namespace BeSimple\SsoAuthBundle\Sso\Cas;

use BeSimple\SsoAuthBundle\Sso\AbstractServer;
use BeSimple\SsoAuthBundle\Sso\ServerInterface;
use Buzz\Message\Request;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class Server extends AbstractServer implements ServerInterface
{
    /**
     * @return string
     */
    public function getLoginUrl()
    {
        return sprintf('%s?service=%s', parent::getLoginUrl(), urlencode($this->getCheckUrl()));
    }

    /**
     * @return string
     */
    public function getLogoutUrl()
    {
        return sprintf('%s?service=%s', parent::getLogoutUrl(), urlencode($this->getCheckUrl()));
    }

    /**
     * @return string
     */
    public function getValidationUrl()
    {
        return sprintf('%s?service=%s', parent::getValidationUrl(), urlencode($this->getCheckUrl()));
    }

    /**
     * {@inheritdoc}
     */
    public function buildValidationRequest($credentials)
    {
        $request = new Request();
        $request->fromUrl(sprintf(
            '%s&ticket=%s',
            $this->getValidationUrl(),
            $credentials
        ));

        return $request;
    }

}
