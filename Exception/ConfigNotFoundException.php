<?php

namespace BeSimple\SsoAuthBundle\Exception;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class ConfigNotFoundException extends NotFoundException
{
    public function __construct($id, $code = null, $previous = null)
    {
        parent::__construct($id, 'Config', $code, $previous);
    }
}
