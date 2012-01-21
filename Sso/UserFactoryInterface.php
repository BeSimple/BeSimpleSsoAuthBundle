<?php

namespace BeSimple\SsoAuthBundle\Sso;

interface UserFactoryInterface 
{
    /**
     * Create a new user for the given username
     * 
     * @param string $username The username
     * @param array $attributes The attributes from the validation
     * 
     * @return UserInterface  
     */
    public function createUser($username, $attributes);
}
