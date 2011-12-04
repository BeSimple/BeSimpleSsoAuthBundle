<?php

namespace BeSimple\SsoAuthBundle\Exception;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class NotFoundException extends \InvalidArgumentException
{
    public function __construct($id, $subject = 'Service', $code = null, $previous = null)
    {
        parent::__construct(sprintf('[BeSimpleSsoAuthBundle] %s "%s" is not defined.', $subject, $id), $code, $previous);
    }
}
