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
$app->get('/index', 'DefaultController:index')->bind('index_2');
$app->get('/login', 'DefaultController:login')->bind('login');
$app->get('/my', 'DefaultController:my')->bind('my');
$app->get('/switch/{identity}', 'DefaultController:switchIdentity')->bind('switchID');

$app->get('/oauth2/login/{type}', 'OAuth2ClientController:login')->bind('login_by_oauth2');
$app->get('/oauth2/confirm/{type}', 'OAuth2ClientController:confirmLogin')->bind('confirm_login_by_oauth2');
// $app->post('/oauth2/bind', 'OAuth2ClientController:accountBind');

//岗位
$app->get('/job/add', 'JobController:add');
$app->post('/job/add', 'JobController:add');
$app->get('/job/edit/{id}', 'JobController:edit');
$app->post('/job/edit/{id}', 'JobController:edit');
$app->get('/job/view/{id}', 'JobController:view');
$app->post('/job/close/{id}', 'JobController:close');
$app->post('/job/open/{id}', 'JobController:open');
$app->get('/job/list', 'JobController:index');
$app->get('/job/index', 'JobController:index');
$app->get('/job/favorites', 'JobController:favorites');
$app->post('/job/favorite/{jobId}/{favorite}', 'JobController:favorite');

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
$app->get('/resume/preview', 'ResumeController:previewSelf');
$app->get('/resume/preview/{rid}', 'ResumeController:preview');
$app->get('/resume/resumes', 'ResumeController:resumes');
$app->post('/resume/delivery/{jobId}', 'ResumeController:delivery');
