<?php

namespace BeSimple\SsoAuthBundle\Sso;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
interface ComponentInterface
{
    /**
     * Setup configuration.
     *
     * @param array $config
     */
    public function setConfig(array $config);
}
