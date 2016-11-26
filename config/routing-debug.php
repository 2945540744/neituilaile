<?php

use Neitui\Controller\Test\TestController;

if (!$app['debug']) {
    return;
}

$app['TestController'] = function () use ($app) {
    return new TestController($app['service.kernel']);
};

$app->get('/test/hellovue', 'TestController:testHelloVue')->bind('test_hello_vue');
$app->get('/test/user/{wid}', 'TestController:testGetUser')->bind('test_user');
$app->get('/test/route/{route}', 'TestController:testRoute')->bind('test_route');
$app->get('/test/logger', 'TestController:testLogger')->bind('test_logger');
$app->get('/test/adduser', 'TestController:testAddUser')->bind('test_add_user');
$app->get('/test/clearsession', 'TestController:testClearSession')->bind('test_clear_session');
$app->get('/test/phpinfo', 'TestController:testPhpinfo')->bind('test_phpinfo');
