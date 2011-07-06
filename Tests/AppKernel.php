<?php

namespace BeSimple\SsoAuthBundle\Tests;

use Symfony\Component\HttpKernel\Util\Filesystem;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    private $tmpPath;
    private $configFile;

    public function __construct($tmpPath, $configFile, $environment, $debug)
    {
        $this->tmpPath    = $tmpPath;
        $this->configFile = $configFile;

        parent::__construct($environment, $debug);
    }

    public function registerBundles()
    {
        $bundles = array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \BeSimple\SsoAuthBundle\BeSimpleSsoAuthBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new \Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }

        return $bundles;
    }

    public function init()
    {
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return $this->tmpPath.'/cache/'.$this->environment;
    }

    public function getLogDir()
    {
        return $this->tmpPath.'/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->configFile);
    }
}
