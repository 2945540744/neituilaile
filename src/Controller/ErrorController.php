<?php

namespace Neitui\Controller;

use Silex\Application;

class ErrorController extends BaseController
{
    public function err401(Application $app)
    {
        return $app['twig']->render('error/401.html');
    }

    public function err403(Application $app)
    {
        return $app['twig']->render('error/403.html');
    }

    public function err404(Application $app)
    {
        return $app['twig']->render('error/404.html');
    }

    public function err500(Application $app)
    {
        $message = $request->query->get('message', 'Internal Error');
        return $app['twig']->render('error/500.html', array(
            'msg' => $message
        ));
    }
}
