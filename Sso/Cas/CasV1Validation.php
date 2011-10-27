<?php

namespace BeSimple\SsoAuthBundle\Sso\Cas;

use BeSimple\SsoAuthBundle\Sso\AbstractValidation;
use BeSimple\SsoAuthBundle\Sso\ValidationInterface;
use Buzz\Message\Response;
 
class CasV1Validation extends AbstractValidation implements ValidationInterface
{
    protected function validateResponse(Response $response)
    {
        $content = $response->getContent();
        $data    = explode("\n", str_replace("\n\n", "\n", str_replace("\r", "\n", $content)));
        $success = strtolower($data[0]) === 'yes';
        $message = (count($data) > 1 && $data[1]) ? $data[1] : null;

        if ($success) {
            $this->username = $message;
        } else {
            $this->error = $message;
        }
        
        return $success;
    }
}
