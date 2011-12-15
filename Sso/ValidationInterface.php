<?php

namespace BeSimple\SsoAuthBundle\Sso;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
interface ValidationInterface
{

    /**
     * Returns validation response.
     *
     * @return \Buzz\Message\Response
     */
    public function getResponse();

    /**
     * Is validation successful?
     *
     * @return bool Validation success
     */
    public function isSuccess();

    /**
     * Returns SSO credentials (token).
     *
     * @return string A SSO token
     */
    public function getCredentials();

    /**
     * Returns username if validation is successful.
     *
     * @return string The username
     */
    public function getUsername();

    /**
     * Returns attributes given by SSO server.
     *
     * @return array An array of attributes
     */
    public function getAttributes();

    /**
     * Returns an error message if validation was not successful.
     *
     * @return string An error message
     */
    public function getError();
}
