<?php

namespace BeSimple\SsoAuthBundle\Tests;

use Buzz\Client\ClientInterface;
use Buzz\Message\Request as BuzzRequest;
use Buzz\Message\Response as BuzzResponse;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpClient implements ClientInterface
{
    static protected $kernel;

    static public function setKernel(Kernel $kernel)
    {
        static::$kernel = $kernel;
    }

    public function send(BuzzRequest $buzzRequest, BuzzResponse $buzzResponse)
    {
        $request  = Request::create($buzzRequest->getUrl(), $buzzRequest->getMethod());
        $response = static::$kernel->handle($request);

        $buzzResponse->setContent($response->getContent());
    }

    public function setTimeout($timeout)
    {
        return;
    }

    public function setMaxRedirects($maxRedirects)
    {
        return;
    }
}