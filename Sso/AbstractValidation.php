<?php

namespace BeSimple\SsoAuthBundle\Sso;

use Buzz\Message\Response;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractValidation implements ValidationInterface
{
    /**
     * Response not validated
     */
    const STATUS_NONE    = 0;

    /**
     * Validation successful
     */
    const STATUS_VALID   = 1;

    /**
     * Validation returns an error
     */
    const STATUS_INVALID = -1;

    /**
     * @var int
     */
    private $status;

    /**
     * @var \Buzz\Message\Response
     */
    private $response;

    /**
     * @var string
     */
    private $credentials;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var string
     */
    protected $error;

    /**
     * Constructor.
     *
     * @param \Buzz\Message\Response $response
     * @param string                 $credentials
     */
    public function __construct(Response $response, $credentials)
    {
        $this->status      = self::STATUS_NONE;
        $this->response    = $response;
        $this->credentials = $credentials;
        $this->username    = '';
        $this->attributes  = array();
        $this->error       = '';
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccess()
    {
        if ($this->status === self::STATUS_NONE) {
            $this->status = $this->validateResponse($this->response)
                ? self::STATUS_VALID
                : self::STATUS_INVALID;
        }

        return $this->status === self::STATUS_VALID;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * {@inheritdoc}
     */
    abstract protected function validateResponse(Response $response);
}
