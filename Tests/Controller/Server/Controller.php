<?php

namespace BeSimple\SsoAuthBundle\Tests\Controller\Server;

use BeSimple\SsoAuthBundle\Tests\Controller\Controller as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\TemplateReference;
use BeSimple\SsoAuthBundle\Tests\Form\Login;
use BeSimple\SsoAuthBundle\Tests\Form\LoginType;

abstract class Controller extends BaseController
{
    const LOGOUT_MESSAGE = 'you are logged out';

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $form    = $this->createLoginForm();
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            return new RedirectResponse($this->getLoginRedirectUrl($request, $form->getData()));
        }

        return $this->render('common/login.html.twig', array(
            'form' => $form->createView(),
            'action' => $request->getRequestUri())
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function validationAction()
    {
        $credentials = $this->getCredentials($this->getRequest());
        $name        = $this->isValidCredentials($credentials) ? 'valid' : 'invalid';
        $view        = $this->getValidationView($this->getRequest(), $name);

        return $this->render($view, array('username' => $credentials));
    }

    public function logoutAction()
    {
        return $this->render('common/link.html.twig', array(
            'message' => self::LOGOUT_MESSAGE,
            'url'     => $this->getLogoutRedirectUrl($this->getRequest()),
        ));
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    protected function createLoginForm()
    {
        return $this->container->get('form.factory')->create(new LoginType(), new Login());
    }

    /**
     * @param string $credentials
     * @return bool
     */
    protected function isValidCredentials($credentials)
    {
        return in_array($credentials, array('user', 'admin'));
    }

    /**
     * @abstract
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param Login $login
     * @return string
     */
    abstract protected function getLoginRedirectUrl(Request $request, Login $login);

    /**
     * @abstract
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    abstract protected function getLogoutRedirectUrl(Request $request);

    /**
     * @abstract
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    abstract protected function getCredentials(Request $request);

    /**
     * @abstract
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string $name
     * @return string
     */
    abstract protected function getValidationView(Request $request, $name);
}
