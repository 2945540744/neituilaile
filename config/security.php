<?php

use Neitui\Context\UserProvider;
use Neitui\Context\AuthenticationEntryPoint;
use Neitui\Context\CustomLogoutSuccessHandler;
use Neitui\Context\NeituiAuthenticationFailureHandler;
use Neitui\Context\NeituiAuthenticationSuccessHandler;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

$app->register(new Silex\Provider\SecurityServiceProvider());
$app->register(new Silex\Provider\RememberMeServiceProvider());

$app->register(new Silex\Provider\LocaleServiceProvider());

$app['security.user_provider.default'] = function ($app) {
    return new UserProvider($app['service.kernel']);
};

$app['security.firewalls'] = array(
    'secured' => array(
        'pattern'     => '^.*$',
        'anonymous'   => true,
        'form'        => array(
            'login_path'  => '/login',
            'use_referer' => true,
            'check_path'  => '/login_check'
        ),
        'remember_me' => array(
            'key'                => 'dsjflkjgewfsefjiwejga',
            'always_remember_me' => true
        ),
        'logout'      => array('logout_path' => '/logout'),
        'users'       => $app['security.user_provider.default']
    )
);

$app['security.role_hierarchy'] = array(
    'ROLE_ROOT' => array('ROLE_USER')
);

$app['security.access_rules'] = array(
    array('^/login', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^/login_check', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^/oauth2', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^/test', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^/job/view', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^/resume/preview', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^/$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^/index$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^.*$', 'ROLE_USER')
    //test only
    // array('^.*$', 'IS_AUTHENTICATED_ANONYMOUSLY')
);

$app['security.default_encoder'] = function ($app) {
    return new MessageDigestPasswordEncoder('sha256');
};

$app['security.authentication.success_handler.secured'] = function ($app) {
    return new NeituiAuthenticationSuccessHandler($app);
};

$app['security.authentication.failure_handler.secured'] = function ($app) {
    return new NeituiAuthenticationFailureHandler($app);
};

$app['security.authentication.logout_handler.secured'] = function ($app) {
    return new CustomLogoutSuccessHandler($app['service.kernel']);
};

$app['security.entry_point.form._proto'] = $app->protect(function ($name, array $options) use ($app) {
    $login_path = isset($options['login_path']) ? $options['login_path'] : '/login';
    return new AuthenticationEntryPoint($app['security.http_utils'], $login_path);
});
