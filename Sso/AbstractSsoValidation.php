<?php

namespace BeSimple\SsoAuthBundle\Sso;

use Buzz\Message\Response;

abstract class AbstractSsoValidation implements SsoValidationInterface
{
    const STATUS_NONE   = 0;
    const STATUS_VALID  = 1;
    const SATUS_INVALID = -1;

    protected $status;
    protected $response;
    protected $username;
    protected $attributes;
    protected $error;

    public function __construct(Response $response)
    {
        $this->status     = self::STATUS_NONE;
        $this->response   = $response;
        $this->username   = null;
        $this->attributes = array();
        $this->error      = null;
    }

    public function isSuccess()
    {
        if ($this->status === self::STATUS_NONE) {
            $this->status = $this->validateResponse($this->response)
                ? self::STATUS_VALID
                : self::SATUS_INVALID;
        }

        return $this->status === self::STATUS_VALID;
    }

    public function getUsername()
    {
        if (!$this->isSuccess()) {
            return null;
        }

        return $this->username;
    }

    public function getAttributes()
    {
        return $this->isSuccess() ? $this->attributes : null;
    }

    public function getError()
    {
        return trim($this->error, "\t\r\n ");
    }

    abstract protected function validateResponse(Response $response);
}
