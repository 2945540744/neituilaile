<?php
namespace Neitui\OAuth\Client;

use Neitui\Context\NLogger;

class WeixinwebOAuthClient extends AbstractOAuthClient
{
    const USERINFO_URL    = 'https://api.weixin.qq.com/sns/userinfo';
    const AUTHORIZE_URL   = 'https://open.weixin.qq.com/connect/qrconnect?';
    const OAUTH_TOKEN_URL = 'https://api.weixin.qq.com/sns/oauth2/access_token';

    public function getAuthorizeUrl($callbackUrl)
    {
        $params                  = array();
        $params['appid']         = $this->config['key'];
        $params['redirect_uri']  = $callbackUrl;
        $params['response_type'] = 'code';
        $params['scope']         = 'snsapi_login';
        return self::AUTHORIZE_URL.http_build_query($params);
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
        NLogger::getLogger('WeixinwebOAuthClient')->debug('getAccessToken : ', $result);
        $this->checkResult($result);
        $rawToken = $result;
        return array(
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
        NLogger::getLogger('WeixinwebOAuthClient')->debug('getUserinfo : ', $result);
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
