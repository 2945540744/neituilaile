<?php

use Neitui\Controller\JobController;
use Neitui\Controller\ResumeController;
use Neitui\Controller\DefaultController;
use Neitui\Controller\OAuth2ClientController;

$app['DefaultController'] = function () use ($app) {
    return new DefaultController($app['service.kernel']);
};

$app['JobController'] = function () use ($app) {
    return new JobController($app['service.kernel']);
};

$app['ResumeController'] = function () use ($app) {
    return new ResumeController($app['service.kernel']);
};

$app['OAuth2ClientController'] = function () use ($app) {
    return new OAuth2ClientController($app['service.kernel']);
};

$app->get('/', 'DefaultController:index')->bind('index');
$app->get('/login', 'DefaultController:login')->bind('login');

$app->get('/oauth2/login/{type}', 'OAuth2ClientController:login')->bind('login_by_oauth2');
$app->get('/oauth2/confirm/{type}', 'OAuth2ClientController:confirmLogin')->bind('confirm_login_by_oauth2');
// $app->post('/oauth2/bind', 'OAuth2ClientController:accountBind');

//岗位
$app->get('/job/add', 'JobController:add');
$app->post('/job/add', 'JobController:add');
$app->get('/job/edit/{id}', 'JobController:edit');
$app->post('/job/edit/{id}', 'JobController:edit');
$app->get('/job/view/{id}', 'JobController:view');
$app->get('/job/list', 'JobController:index');
$app->get('/job/index', 'JobController:index');

// $app->post('/job/add','JobController:add');

//简历
$app->get('/resume/index', 'ResumeController:index');
$app->get('/resume/edit/basic', 'ResumeController:editBasic');
$app->post('/resume/edit/basic', 'ResumeController:editBasic');
$app->get('/resume/edit/edu', 'ResumeController:editEdu');
$app->post('/resume/edit/edu', 'ResumeController:editEdu');
$app->get('/resume/edit/exp', 'ResumeController:editExp');
$app->post('/resume/edit/exp', 'ResumeController:editExp');
$app->get('/resume/edit/intent', 'ResumeController:editIntent');
$app->post('/resume/edit/intent', 'ResumeController:editIntent');
$app->post('/resume/delete/{type}/{id}', 'ResumeController:delete');
