<?php

namespace Neitui\Controller;

use Silex\Application;
use Neitui\Context\CurrentUser;
use Neitui\Common\SecurityToolkit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends BaseController
{
    public function index(Application $app)
    {
        return new RedirectResponse('/my');
    }

    public function login(Application $app, Request $request)
    {
        $curUser = $app['user'];
        if (empty($curUser)) {
            $redirect = $request->headers->get('referer');
            return new RedirectResponse('/oauth2/login/weixin?service='.urlencode($redirect ? $redirect : '/'));
        }
        return new RedirectResponse('/');
    }

    public function my(Application $app)
    {
        $curUser = $app['user'];
        return $app['twig']->render('frontend/my-'.strtolower($curUser->getCurrentIdentity()).'.html.twig', array(
            'user' => $curUser
        ));
    }

    public function switchIdentity(Application $app, Request $request, $identity)
    {
        $curUser = $app['user'];

        $user = $this->getUserService()->switchUserIdentity($curUser['id'], $identity);
        SecurityToolkit::login($app, $request, new CurrentUser($user));

        return new RedirectResponse('/my');
    }

    protected function getUserService()
    {
        return $this->kernel->service('Neitui:UserService');
    }
}
