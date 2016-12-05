<?php

namespace Neitui\Common;

use Silex\Application;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityToolkit
{
    public static function rand($len)
    {
        if ($len <= 0) {
            return '';
        }

        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        $data    = '';
        for ($i = 0; $i < $len; $i++) {
            $data .= $letters[rand(0, 61)];
        }

        return $data;
    }

    public static function login(Application $app, $request, $currentUser)
    {
        $token = new UsernamePasswordToken($currentUser, null, 'secured', $currentUser->getRoles());
        $app['security.token_storage']->setToken($token);
        $request->getSession()->set('_security_secured', serialize($token));
        // $app['service.kernel']->setUser($currentUser);

//         self::configTgc($app);

        // $service = $request->query->get('service');
        // if (empty($service)) {
        //     $service = $request->getSession()->get('service');
        // }

//         self::createLoginLog($app, $request, $currentUser, $service);
    }
}
