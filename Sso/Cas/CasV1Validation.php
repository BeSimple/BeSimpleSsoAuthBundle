<?php

namespace BeSimple\SsoAuthBundle\Sso\Cas;

use BeSimple\SsoAuthBundle\Sso\AbstractSsoValidation;
use BeSimple\SsoAuthBundle\Sso\SsoValidationInterface;
use Buzz\Message\Response;
 
class Cas1Validation extends AbstractSsoValidation implements SsoValidationInterface
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
