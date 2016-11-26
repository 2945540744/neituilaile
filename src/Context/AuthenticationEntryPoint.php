<?php

namespace Neitui\Context;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    protected $login_path = '/login';
    protected $http_tools;

    public function __construct(HttpUtils $http_utils, $login_path = '')
    {
        $this->http_tools = $http_utils;
        if ($login_path) {
            $this->login_path = $login_path;
        }
    }

    public function start(Request $request, AuthenticationException $ex = null)
    {
        $request->getSession()->set('req_url_before_login', $request->getPathInfo());
        if (!$request->isXmlHttpRequest()) {
            return new RedirectResponse($this->login_path);
        } else {
            return new Response('Auth header required', 401);
        }
    }
}
