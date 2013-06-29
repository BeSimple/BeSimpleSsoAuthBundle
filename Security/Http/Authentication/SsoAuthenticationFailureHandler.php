<?php

namespace BeSimple\SsoAuthBundle\Security\Http\Authentication;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

class SsoAuthenticationFailureHandler implements AuthenticationFailureHandlerInterface
{
    private $templating;

    /**
     * @param $templating Templating service for rendering responses.
     */
    public function __construct($templating)
    {
        $this->templating = $templating;
    }

    /**
     * This is called when an interactive authentication attempt fails.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->isXmlHttpRequest()) {
            $result = array('success' => false);
            return new Response(json_encode($result));
        } else {
            // Handle non XmlHttp request.
            $parameters = array(
                'status_text' => $exception->getMessage(),
                'status_code' => $exception->getCode(),
            );

            return $this->templating->renderResponse('TwigBundle:Exception:error.html.twig', $parameters);
        }
    }
}
