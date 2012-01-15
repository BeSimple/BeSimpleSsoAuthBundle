<?php

namespace BeSimple\SsoAuthBundle\Security\Core\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use BeSimple\SsoAuthBundle\Sso\Manager;
use BeSimple\SsoAuthBundle\Security\Core\Authentication\Token\SsoToken;
use BeSimple\SsoAuthBundle\Sso\ValidationInterface;

class SsoAuthenticationProvider implements AuthenticationProviderInterface
{
    /**
     * @var UserProviderInterface
     */
    private $userProvider;

    /**
     * @var UserCheckerInterface
     */
    private $userChecker;

    /**
     * @var bool
     */
    private $hideUserNotFoundExceptions;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\Security\Core\User\UserProviderInterface $userProvider
     * @param \Symfony\Component\Security\Core\User\UserCheckerInterface  $userChecker
     * @param bool                                                        $hideUserNotFoundExceptions
     */
    public function __construct(UserProviderInterface $userProvider, UserCheckerInterface $userChecker, $hideUserNotFoundExceptions = true)
    {
        $this->userProvider               = $userProvider;
        $this->userChecker                = $userChecker;
        $this->hideUserNotFoundExceptions = $hideUserNotFoundExceptions;
    }

    /**
     * @throws \Symfony\Component\Security\Core\Exception\AuthenticationServiceException
     *
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     *
     * @return SsoToken|null
     */
    public function authenticate(TokenInterface $token)
    {
        if (!$this->supports($token)) {
            return null;
        }

        $validation = $token->validate();
        if (!$validation->isSuccess()) {
            throw new BadCredentialsException('Authentication has not been validated by SSO provider.');
        }

        $user = $this->provideUser($validation->getUsername());
        $this->userChecker->checkPreAuth($user);
        $this->userChecker->checkPostAuth($user);

        $token = new SsoToken($token->getManager(), $token->getCredentials(), $user, $user->getRoles());
        $token->setAttributes($token->getAttributes());

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof SsoToken;
    }

    /**
     * @throws \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     * @throws \Symfony\Component\Security\Core\Exception\BadCredentialsException
     *
     * @param string $username
     *
     * @return UserInterface
     */
    protected function provideUser($username)
    {
        try {
            $user = $this->retrieveUser($username);
        } catch (UsernameNotFoundException $notFound) {
            if ($this->hideUserNotFoundExceptions) {
                throw new BadCredentialsException('Bad credentials', 0, $notFound);
            } else {
                throw $notFound;
            }
        }

        return $user;
    }

    /**
     * @throws \Symfony\Component\Security\Core\Exception\AuthenticationServiceException
     *
     * @param string $username
     *
     * @return UserInterface
     */
    protected function retrieveUser($username)
    {
        try {
            $user = $this->userProvider->loadUserByUsername($username);

            if (!$user instanceof UserInterface) {
                throw new AuthenticationServiceException('The user provider must return an UserInterface object.');
            }
        } catch (UsernameNotFoundException $notFound) {
            throw $notFound;
        } catch (\Exception $repositoryProblem) {
            throw new AuthenticationServiceException($repositoryProblem->getMessage(), $username, 0, $repositoryProblem);
        }

        return $user;
    }
}
