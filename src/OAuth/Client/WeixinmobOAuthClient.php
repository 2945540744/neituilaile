<?php

namespace Neitui\OAuth\Client;

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
        // NLogger::getLogger('WeixinmobOAuthClient')->debug('getAccessToken : ', $result);
        $this->checkResult($result);
        return array(
            // 'userId'       => $result['tpid'],
            'expiredTime'  => $result['expires_in'],
            'access_token' => $result['access_token'],
            'token'        => $result['access_token'],
            'openid'       => $result['openid']
        );
    }

    public function getUserInfo($token)
    {
        $params = array(
            'openid'       => $token['openid'],
            'access_token' => $token['access_token']);
        $result = $this->getRequest(self::USERINFO_URL, $params);
        // NLogger::getLogger('WeixinmobOAuthClient')->debug('getUserInfo : ', $result);
        $this->checkResult($result);
        $token['unionid']  = $result['unionid'];
        $token['nickname'] = $result['nickname'];
        $token['avatar']   = $result['headimgurl'];
        $token['gender']   = $result['sex'];
        return $token;
    }

    private function checkResult($result)
    {
        if (isset($result['errcode'])) {
            throw new \Exception('与微信通讯出错：'.$result['errmsg']);
        }
    }
}
