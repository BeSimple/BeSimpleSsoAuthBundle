<?php

namespace BeSimple\SsoAuthBundle\Buzz;

use Buzz\Client\ClientInterface;
use Buzz\Client\Curl;
use Buzz\Client\FileGetContents;
use Buzz\Message\Request;
use Buzz\Message\Response;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class AdaptiveContainer implements ClientInterface
{
    private $client;

    public function __construct()
    {
        $this->client = function_exists('curl_init') ? new Curl() : new FileGetContents();
    }

    public function send(Request $request, Response $response)
    {
        $this->client->send($request, $response);
    }
}
