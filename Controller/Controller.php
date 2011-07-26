<?php

namespace BeSimple\SsoAuthBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Controller extends ContainerAware
{
    protected function render($view, array $parameters)
    {
        return $this
            ->container
            ->get('templating')
            ->renderResponse($view, $parameters)
        ;
    }
}
