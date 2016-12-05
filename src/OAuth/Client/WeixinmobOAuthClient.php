<?php

namespace Neitui\OAuth\Client;

use Neitui\Context\NLogger;

class WeixinmobOAuthClient extends AbstractOAuthClient
{
    const USERINFO_URL    = 'https://api.weixin.qq.com/sns/userinfo';
    const AUTHORIZE_URL   = 'https://open.weixin.qq.com/connect/oauth2/authorize?';
    const OAUTH_TOKEN_URL = 'https://api.weixin.qq.com/sns/oauth2/access_token';

    public function getAuthorizeUrl($callbackUrl)
    {
        $params                  = array();
        $params['appid']         = $this->config['key'];
        $params['redirect_uri']  = $callbackUrl;
        $params['response_type'] = 'code';
        $params['scope']         = 'snsapi_userinfo'; //snsapi_login

        return self::AUTHORIZE_URL.http_build_query($params).'#wechat_redirect';
    }

    public function getAccessToken($code, $callbackUrl)
    {
        $params = array(
            'appid'      => $this->config['key'],
            'secret'     => $this->config['secret'],
            'code'       => $code,
            'grant_type' => 'authorization_code'
        );
        $result = $this->getRequest(self::OAUTH_TOKEN_URL, $params);
        NLogger::getLogger('WeixinmobOAuthClient')->debug('getAccessToken : ', $result);
        $rawToken = array();
        $rawToken = json_decode($result, true);
        return array(
            'userId'       => $userInfo['tpid'],
            'expiredTime'  => $rawToken['expires_in'],
            'access_token' => $rawToken['access_token'],
            'token'        => $rawToken['access_token'],
            'openid'       => $rawToken['openid']
        );
    }

    public function getUserInfo($token)
    {
        $params = array(
            'openid'       => $token['openid'],
            'access_token' => $token['access_token']);
        $result = $this->getRequest(self::USERINFO_URL, $params);
        NLogger::getLogger('WeixinmobOAuthClient')->debug('getUserInfo : ', $result);
        $info              = json_decode($result, true);
        $token['unionid']  = $info['unionid'];
        $token['nickname'] = $info['nickname'];
        $token['avatar']   = $info['headimgurl'];
        $token['gender']   = $info['sex'];
        return $token;
    }

}
