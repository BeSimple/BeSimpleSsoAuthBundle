<?php

namespace BeSimple\SsoAuthBundle\Sso\Cas;

use BeSimple\SsoAuthBundle\Sso\AbstractProtocol;
use BeSimple\SsoAuthBundle\Sso\ProtocolInterface;
use BeSimple\SsoAuthBundle\Exception\InvalidConfigurationException;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Buzz\Message\Request as BuzzRequest;
use Buzz\Message\Response as BuzzResponse;
use Buzz\Client\ClientInterface;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class Protocol extends AbstractProtocol
{
    /**
     * {@inheritdoc}
     */
    public function isValidationRequest(SymfonyRequest $request)
    {
        return $request->query->has('ticket');
    }

    /**
     * {@inheritdoc}
     */
    public function extractCredentials(SymfonyRequest $request)
    {
        return $request->query->get('ticket');
    }

    /**
     * {@inheritdoc}
     */
    public function executeValidation(ClientInterface $client, BuzzRequest $request, $credentials)
    {
        $response = new BuzzResponse();
        $client->send($request, $response);

        switch ($this->getConfigValue('version')) {
            case 1: return new PlainValidation($response, $credentials);
            case 2: return new XmlValidation($response, $credentials);
        }

        throw new InvalidConfigurationException('Version should either be 1 or 2.');
    }

}
