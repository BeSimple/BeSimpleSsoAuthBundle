<?php

namespace BeSimple\SsoAuthBundle\Security\Core\Authentication\Token;

use BeSimple\SsoAuthBundle\Sso\SsoProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class SsoToken extends AbstractToken
{
    private $ssoProvider;
    private $credentials;

    /**
     * Constructor.
     *
     * @param string $user        The username (like a nickname, email address, etc.)
     * @param string $credentials This usually is the password of the user
     * @param string $providerKey The provider key
     * @param array  $roles       An array of roles
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(SsoProviderInterface $ssoProvider, $credentials, $user = null, array $roles = array())
    {
        parent::__construct($roles);

        $this->ssoProvider = $ssoProvider;
        $this->credentials = $credentials;

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

    public function getSsoProvider()
    {
        return $this->ssoProvider;
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
        return serialize(array($this->credentials, $this->ssoProvider, parent::serialize()));
    }

    public function unserialize($str)
    {
        list($this->credentials, $this->ssoProvider, $parentStr) = unserialize($str);
        parent::unserialize($parentStr);
    }
}
