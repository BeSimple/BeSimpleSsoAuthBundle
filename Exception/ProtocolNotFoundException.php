<?php

namespace BeSimple\SsoAuthBundle\Exception;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class ProtocolNotFoundException extends NotFoundException
{
    public function __construct($id, $code = null, $previous = null)
    {
        parent::__construct('Protocol', $id, $code, $previous);
    }
}
