<?php

namespace Neitui\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends BaseController
{
    public function login(Application $app, Request $request)
    {
        $curUser = $app['user'];
        if (empty($curUser)) {
            $redirect = $request->headers->get('referer');
            return new RedirectResponse('/oauth2/login/weixin?service='.urlencode($redirect ? $redirect : '/job/index'));
        }
        return new RedirectResponse('/job/index');
    }

    public function index(Application $app)
    {
        return new RedirectResponse('/job/index');
    }
}
