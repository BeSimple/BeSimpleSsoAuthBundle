<?php

namespace BeSimple\SsoAuthBundle\Tests\Conroller\Server;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\TemplateReference;
use BeSimple\SsoAuthBundle\Tests\Form\Login;
use BeSimple\SsoAuthBundle\Tests\Form\LoginType;

abstract class Controller extends ContainerAware
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $form    = $this->createLoginForm();
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            return new RedirectResponse($this->getLoginRedirectUrl($request, $form->getData()));
        }

        return $this->render('login.html.twig', array('form' => $form));
    }

    /**
     * @param string $credentials
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function validationAction($credentials)
    {
        $view      = $this->isValidCredentials($credentials) ? 'valid' : 'invalid';
        $directory = $this->getViewDirectory($this->getRequest());

        return $this->render(sprintf('%s/%s.html.twig', $directory, $view), array('credentials' => $credentials));
    }

    /**
     * @param string $view
     * @param array $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function render($view, array $parameters = array())
    {
        $path      = realpath(sprintf(__DIR__.'/../../Resources/view/%s', $view));
        $reference = new TemplateReference($path, 'twig');

        return $this->container->get('templating')->render($reference, $parameters);
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    protected function createLoginForm()
    {
        return $this->container->get('form.factory')->createForm(new LoginType(), new Login());
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->container->get('request');
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
     * @param string $credentials
     * @return string
     */
    abstract protected function getLoginRedirectUrl(Request $request, Login $login);

    /**
     * @abstract
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return string
     */
    abstract protected function getViewDirectory(Request $request);
}