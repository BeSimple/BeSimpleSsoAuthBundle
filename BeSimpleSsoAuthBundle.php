<?php

namespace BeSimple\SsoAuthBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use BeSimple\SsoAuthBundle\DependencyInjection\Compiler\FactoryPass;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class BeSimpleSsoAuthBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FactoryPass());
    }
}
