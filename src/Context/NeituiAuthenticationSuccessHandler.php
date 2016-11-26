<?php

namespace Neitui\Context;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class NeituiAuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct($app, array $options = array())
    {
        $this->app    = $app;
        $this->kernel = $this->getKernel();
        parent::__construct($app['security.http_utils'], $options);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        //TODO do something after login success
    }

    protected function getUserService()
    {
        return $this->kernel->service('Neitui:UserService');
    }

    protected function getKernel()
    {
        return $this->app['service.kernel'];
    }
}
