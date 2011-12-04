<?php

namespace BeSimple\SsoAuthBundle\Sso\Cas;

use BeSimple\SsoAuthBundle\Sso\AbstractValidation;
use BeSimple\SsoAuthBundle\Sso\ValidationInterface;
use Buzz\Message\Response;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class XmlValidation extends AbstractValidation implements ValidationInterface
{
    /**
     * {@inheritdoc}
     */
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
                            foreach($child->childNodes as $attr) {
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
