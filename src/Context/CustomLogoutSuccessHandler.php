<?php

namespace Neitui\Context;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class CustomLogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
    protected $kernel;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    public function onLogoutSuccess(Request $request)
    {
        $session = $request->getSession();
        $session->invalidate();

        $redirect_url = '/login';

        return new RedirectResponse('/login');
    }
}
