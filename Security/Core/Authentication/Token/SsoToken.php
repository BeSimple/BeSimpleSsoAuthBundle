<?php

namespace BeSimple\SsoAuthBundle\Security\Core\Authentication\Token;

use BeSimple\SsoAuthBundle\Sso\Manager;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class SsoToken extends AbstractToken
{
    private $manager;
    private $credentials;

    /**
     * Constructor.
     *
     * @param Manager $manager              The SSO manager
     * @param string  $credentials          The SSO token
     * @param string  $user                 The username
     * @param array   $roles                An array of roles
     * @param array   $validationAttributes An array of attributes
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Manager $manager, $credentials, $user = null, array $roles = array(), array $validationAttributes = array())
    {
        parent::__construct($roles);

        $this->manager              = $manager;
        $this->credentials          = $credentials;

        $this->setAttribute('sso:validation', $validationAttributes);

        if (!is_null($user)) {
            $this->setUser($user);

            parent::setAuthenticated(true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthenticated($isAuthenticated)
    {
        if ($isAuthenticated) {
            throw new \LogicException('Cannot set this token to trusted after instantiation.');
        }

        parent::setAuthenticated(false);
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function getValidationAttributes()
    {
        if (!$this->hasAttribute('sso:validation')) {
            return array();
        }

        return $this->getAttribute('sso:validation');
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        parent::eraseCredentials();

        $this->credentials = null;
    }

    public function serialize()
    {
        return serialize(array($this->credentials, $this->manager, parent::serialize()));
    }

    public function unserialize($str)
    {
        list($this->credentials, $this->manager, $parentStr) = unserialize($str);
        parent::unserialize($parentStr);
    }
}
