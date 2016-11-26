<?php

namespace Neitui\Controller\Test;

use Monolog\Logger;
use Silex\Application;
use Neitui\Context\LogFactory;
use Neitui\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TestController extends BaseController
{
    public function testHelloVue(Application $app, Request $request)
    {
        return new RedirectResponse('/test/hello-vue.html');
    }

    public function testGetUser(Application $app, Request $request, $wid)
    {
        $user = $this->getUserService()->register(array(
            'username'    => 'tesdsagt1',
            'email'       => 'test1@test.com',
            'password'    => 'testss1',
            'outer_id_wx' => $wid
        ));

        $found = $this->getUserService()->getUserByWeixinId($user['outer_id_wx']);

        return $this->jsonData($found);
    }

    public function testRoute(Application $app, Request $request, $route)
    {
        $route = str_replace('_', '/', $route);

        return $app['twig']->render($route.'.html.twig', array());
    }

    public function testLogger(Application $app, Request $request)
    {
        $logger = LogFactory::getLogger('TestController', Logger::INFO);
        $logger->debug('debug : '.time()); //write nothing
        $logger->info('info : '.time()); //write log
        return true;
    }

    public function testAddUser(Application $app, Request $request)
    {
        $user = array(
            'nickname'   => 'dsaf32fas',
            'sex'        => 1,
            'unionid'    => 'sfdsfadsfsd',
            'headimgurl' => 'http://amsmgds',
            'openid'     => 'dsdddasdsags'
        );

        $this->getUserService()->getUserInfo($user, 'weixinmob');
        return true;
    }

    public function testClearSession(Application $app, Request $request)
    {
        $request->getSession()->invalidate();
        return true;
    }

    public function testPhpinfo(Application $app, Request $request)
    {
        phpinfo();
    }

    protected function getUserService()
    {
        return $this->kernel->service('Neitui:UserService');
    }
}
