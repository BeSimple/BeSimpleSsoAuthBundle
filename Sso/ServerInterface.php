<?php

namespace BeSimple\SsoAuthBundle\Sso;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
interface ServerInterface extends ComponentInterface
{
    /**
     * Returns the login URL of this server.
     *
     * Depending on the protocol, this URL can point to a login form
     * or just an API on which to post login data (or even both).
     *
     * @return string
     */
    public function getLoginUrl();

    /**
     * Returns the logout URL of this server.
     *
     * @return string
     */
    public function getLogoutUrl();

    /**
     * Returns the URL to be redirected to after logout.
     *
     * @return string
     */
    public function getLogoutTarget();

    /**
     * Returns the check URL.
     *
     * @return string
     */
    public function getCheckUrl();

    /**
     * Builds a validation request for given credentials.
     *
     * @param string $credentials
     *
     * @return \Buzz\Message\RequestInterface
     */
    public function buildValidationRequest($credentials);
}
