<?php

namespace Neitui\Context;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

class NeituiAuthenticationFailureHandler extends DefaultAuthenticationFailureHandler implements AuthenticationFailureHandlerInterface
{
    public function __construct($app, array $options = array())
    {
        $this->app    = $app;
        $this->kernel = $this->getKernel();
        parent::__construct($app, $app['security.http_utils'], $options);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $params = $request->query->all();

        $params['error'] = $this->app['translator']->trans($exception->getMessage());

        return new RedirectResponse('/login?'.http_build_query($params));
    }

    protected function getKernel()
    {
        return $this->app['service.kernel'];
    }
}
