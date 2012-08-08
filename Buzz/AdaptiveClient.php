<?php

namespace BeSimple\SsoAuthBundle\Buzz;

use Buzz\Client\ClientInterface;
use Buzz\Client\Curl;
use Buzz\Client\FileGetContents;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class AdaptiveClient implements ClientInterface
{
    private $client;

    public function __construct()
    {
        $this->client = function_exists('curl_init') ? new Curl() : new FileGetContents();
    }

    public function send(RequestInterface $request, MessageInterface $response)
    {
        $this->client->send($request, $response);
    }
}
