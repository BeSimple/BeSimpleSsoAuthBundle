<?php

namespace BeSimple\SsoAuthBundle\Security\Core\User;

/**
 * @author: Sergio Gómez
 * @author: Jean-François Simon <contact@jfsimon.fr>
 *
 * Interface implemented by user providers able to create new users.
 */
interface UserFactoryInterface
{
    /**
     * Creates a new user for the given username
     *
     * @param string $username The username
     * @param array $roles Roles assigned to user
     * @param array $attributes Attributes provided by SSO server
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function createUser($username, array $roles, array $attributes);
}
