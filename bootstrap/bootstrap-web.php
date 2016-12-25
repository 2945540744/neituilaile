<?php

use Silex\Application;
use Neitui\OAuth\OAuthClientFactory;
use Silex\Provider\SessionServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

define('ROOT_DIR', dirname(__DIR__));

require_once ROOT_DIR.'/vendor/autoload.php';

$parameters = require ROOT_DIR.'/config/parameters.php';

define('PUB_FILE_DIR', $parameters['pub_file_dir'], true);

$app = new Application();

$app['aouth_factory'] = new OAuthClientFactory($parameters['oauth_clients']);

$app['service.kernel'] = new Neitui\Context\NeituiKernel($parameters);
$app['service.kernel']->boot();

$app['debug'] = empty($parameters['debug']) ? false : $parameters['debug'];

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => ROOT_DIR.'/views'
));
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    $twig->addExtension(new Neitui\Common\SysParamExtension());
    $twig->addExtension(new Neitui\Common\WebExtension());
    return $twig;
});

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => ROOT_DIR.'/var/logs/app.log'
));

//session config
$app->register(new Silex\Provider\SessionServiceProvider());
$app['session.storage.options'] = array(
    'cookie_lifetime' => 60 * 60
);

$app->before(function (Request $request, Application $app) {
//     if ($app['user']) {
    //         $app['service.kernel']->setUser($app['user']);
    //     }

    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

//email sending settings
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app['swiftmailer.options'] = $parameters['mail'];

$app['service.kernel']->mailer($app['mailer']);

//redis config, use by $app['redis']
// $app->register(new RedisServiceProvider(), array(
//     'redis.host'                => '127.0.0.1',
//     'redis.port'                => 6379,
//     'redis.timeout'             => 30,
//     'redis.persistent'          => true,
//     'redis.serializer.igbinary' => false, // use igBinary serialize/unserialize
//     'redis.serializer.php'      => false, // use built-in serialize/unserialize
//     'redis.prefix'              => 'myprefix',
//     'redis.database'            => '0'
// ));

include ROOT_DIR.'/config/security.php';
include ROOT_DIR.'/config/routing.php';
include ROOT_DIR.'/config/routing-debug.php';

$app->error(function ($exception, $request, $code) use ($app) {
    $msg = $exception->getTraceAsString();
    $app['logger']->error($exception->getTraceAsString());
    if ($request->isXmlHttpRequest()) {
        return new JsonResponse(array('success' => false, 'error' => $exception->getMessage(), 'message' => $exception->getMessage()), 200);
    } else {
        return $app['twig']->render('error/500.html', array('msg' => $exception->getMessage()));
    }
});

$app->run();
