<?php

namespace BeSimple\SsoAuthBundle\Tests\Controller;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $view
     * @param array $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function render($view, array $parameters = array())
    {
        $path      = realpath(sprintf(__DIR__.'/../Resources/views/%s', $view));
        $reference = new TemplateReference($path, 'twig');
        
        return new Response($this->container->get('templating')->render($reference, $parameters));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->container->get('request');
    }
}