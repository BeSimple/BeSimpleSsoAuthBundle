<?php

namespace BeSimple\SsoAuthBundle\Exception;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class ProtocolNotFoundException extends NotFoundException
{
    public function __construct($id, $code = null, $previous = null)
    {
        parent::__construct($id, 'Protocol', $code, $previous);
    }
}
