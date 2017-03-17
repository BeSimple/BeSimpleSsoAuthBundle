<?php

namespace BeSimple\SsoAuthBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Controller implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container=$container;
    }

    protected function render($view, array $parameters)
    {
        return $this
            ->container
            ->get('templating')
            ->renderResponse($view, $parameters)
        ;
    }
}
