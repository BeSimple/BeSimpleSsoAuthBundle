<?php

namespace BeSimple\SsoAuthBundle\Sso\Cas;

use BeSimple\SsoAuthBundle\Sso\AbstractSsoValidation;
use BeSimple\SsoAuthBundle\Sso\SsoValidationInterface;
use Buzz\Message\Response;
 
class Cas2Validation extends AbstractSsoValidation implements SsoValidationInterface
{
    protected function validateResponse(Response $response)
    {
        $content = $response->getContent();
        $success = false;
        $xml     = new \DOMDocument();

        if ($xml->loadXML($content)) {
            foreach ($xml->firstChild->childNodes as $child) {
                if ($child->nodeName === 'cas:authenticationSuccess') {
                    $root = $child;
                    $success = true;
                    break;
                } elseif ($child->nodeName === 'cas:authenticationFailure') {
                    $root = $child;
                    $success = false;
                    break;
                }
            }

            if ($success) {
                foreach ($root->childNodes as $child) {
                    switch ($child->nodeName) {

                        case 'cas:user':
                            $this->username = $child->textContent;
                            break;

                        case 'cas:attributes':
                            foreach($child->childrenNodes as $attr) {
                                if ($attr->nodeName != '#text') {
                                    $this->attributes[$attr->nodeName] = $attr->textContent;
                                }
                            }
                            break;

                        case 'cas:attribute':
                            $name = $child->attributes->getNamedItem('name')->value;
                            $value = $child->attributes->getNamedItem('value')->value;
                            if ($name && $value) {
                                $this->attributes[$name] = $value;
                            }
                            break;

                        case '#text':
                            break;

                        default:
                            $this->attributes[substr($child->nodeName, 4)] = $child->textContent;
                    }
                }
            } else {
                $this->error = (string)$root->textContent;
            }

        } else {
            $success = false;
            $this->error = 'Invalid response';
        }

        return $success;
    }
}
