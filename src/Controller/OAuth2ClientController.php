<?php
namespace Neitui\Controller;

use Silex\Application;
use Neitui\Context\NLogger;
use Neitui\Common\FileToolkit;
use Neitui\Common\FileUploader;
use Neitui\Context\CurrentUser;
use Neitui\Common\SecurityToolkit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OAuth2ClientController extends BaseController
{
    public function login(Application $app, Request $request, $type)
    {
        if ($type === 'weixin' && preg_match('/MicroMessenger/i', $request->headers->get('user-agent')) === 1) {
            $type = 'weixinmob';
        }
        $client      = $app['aouth_factory']->create($type);
        $callbackUrl = $request->getSchemeAndHttpHost().'/oauth2/confirm/'.$type;
        $service     = $request->query->get('service');
        if (!empty($service)) {
            $callbackUrl .= '?service='.base64_encode($service);
        }
        $url = $client->getAuthorizeUrl($callbackUrl);
        return new RedirectResponse($url);
    }

    public function confirmLogin(Application $app, Request $request, $type)
    {
        $client      = $app['aouth_factory']->create($type);
        $code        = $request->query->get('code');
        $callbackUrl = $request->getSchemeAndHttpHost().'/oauth2/confirm/'.$type;
        $service     = $request->query->get('service');
        if (!empty($service)) {
            $callbackUrl .= '?service='.$service;
        }
        $token    = $client->getAccessToken($code, $callbackUrl);
        $userInfo = $client->getUserInfo($token);
        // $userInfo['headimgurl'] = $this->downloadAvatar($userInfo['avatar']);
        //处理微信用户与我们用户的对应
        $user = $this->getUserService()->register($userInfo, $type);
        NLogger::getLogger('OAuth2ClientController')->debug('confirmLogin user : ', $user);
        SecurityToolkit::login($app, $request, new CurrentUser($user));

        return new RedirectResponse($service ? base64_decode($service) : '/');
    }

    private function downloadAvatar($uri)
    {
        $furi     = FileUploader::generateUri(array('public' => true, 'code' => 'avatar'), 'jpeg');
        $real_uri = explode('://', $furi)[1];
        FileToolkit::downloadImg($uri, PUB_FILE_DIR.$real_uri);

        return $this->getUserService()->cropAvatar($real_uri);
    }

    protected function getUserService()
    {
        return $this->kernel->service('Neitui:UserService');
    }
}
