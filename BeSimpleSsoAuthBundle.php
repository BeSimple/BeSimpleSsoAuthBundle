<?php

namespace BeSimple\SsoAuthBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use BeSimple\SsoAuthBundle\DependencyInjection\Compiler\FactoryPass;

class BeSimpleSsoAuthBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FactoryPass());
    }
}
