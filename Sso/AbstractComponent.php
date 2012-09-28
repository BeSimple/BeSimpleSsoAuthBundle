<?php

namespace BeSimple\SsoAuthBundle\Sso;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractComponent implements ComponentInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->config = array();
    }

    /**
     * Returns server config.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Setup server configuration.
     *
     * @param array $config
     *
     * @return \BeSimple\SsoAuthBundle\Sso\AbstractComponent
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Returns a configuration value
     *
     * @param $name
     * @return string|null
     */
    public function getConfigValue($name)
    {
        return array_key_exists($name, $this->config) ? $this->config[$name] : null;
    }
}
