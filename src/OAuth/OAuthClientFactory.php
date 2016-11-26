<?php
namespace Neitui\OAuth;

use \InvalidArgumentException;

class OAuthClientFactory
{
    private $clients;

    public function __construct($clients)
    {
        $this->clients = $clients;
    }

    /**
     * 创建OAuthClient实例
     *
     * @param  string                $type   Client的类型
     * @param  array                 $config 必需包含key, secret两个参数
     * @return AbstractOauthClient
     */
    public function create($type)
    {
        $clients = $this->clients;

        if (!array_key_exists($type, $clients)) {
            throw new InvalidArgumentException(array('参数不正确%type%', array('%type%' => $type)));
        }

        $config = $clients[$type];
        if (!array_key_exists('key', $config) || !array_key_exists('secret', $config)) {
            throw new InvalidArgumentException('参数中必需包含key, secret两个为key的值');
        }

        $class = $config['class'];

        return new $class($config);
    }
}
