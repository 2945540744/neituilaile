<?php
namespace Neitui\OAuth\Client;

use Neitui\Common\CurlToolkit;

abstract class AbstractOAuthClient
{
    protected $config;

    protected $userAgent = 'Neitui OAuth Client 2.0';

    protected $connectTimeout = 30;

    protected $timeout = 30;

    public function __construct($config)
    {
        $this->config = $config;
    }

    abstract public function getAuthorizeUrl($callbackUrl);

    abstract public function getAccessToken($code, $callbackUrl);

    abstract public function getUserInfo($token);

    /**
     * HTTP POST
     * @param  string   $url    要请求的url地址
     * @param  array    $params 请求的参数
     * @return string
     */
    public function postRequest($url, $params)
    {
        return CurlToolkit::request('POST', $url, $params, array(), array(
            'connectTimeout' => $this->connectTimeout,
            'timeout'        => $this->timeout
        ));
    }

    public function getRequest($url, $params)
    {
        return CurlToolkit::request('GET', $url, $params, array(), array(
            'connectTimeout' => $this->connectTimeout,
            'timeout'        => $this->timeout
        ));
    }
}
