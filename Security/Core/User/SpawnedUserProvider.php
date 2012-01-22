<?php

namespace BeSimple\SsoAuthBundle\Security\Core\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\User;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 *
 * This provider just spawn users on demand, affecting them given $roles.
 */
class SpawnedUserProvider implements UserProviderInterface
{
    /**
     * @var array
     */
    private $roles;

    /**
     * Constructor.
     *
     * @param array $roles An array of roles
     */
    public function __construct(array $roles = array())
    {
        $this->roles = $roles;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {
        return $this->spawnUser($username);
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->spawnUser($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }

    /**
     * Spawns a new user with given username.
     *
     * @param string $username
     *
     * @return \Symfony\Component\Security\Core\User\User
     */
    private function spawnUser($username)
    {
        return new User($username, null, $this->roles, true, true, true, true);
    }
}
