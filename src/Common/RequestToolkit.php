<?php

namespace Neitui\Common;

use Symfony\Component\HttpFoundation\Request;

class RequestToolkit
{
    public static function getPostData(Request $request)
    {
        //客户端传递的数据可能是www-urlencoded-form 或者json格式
        $data = $request->request->all();
        if (empty($data)) {
            $content = $request->getContent();
            if (!empty($content)) {
                return json_decode($content, true);
            }
            return $content;
        }

        return $data;
    }

    public static function getDomain($url)
    {
        preg_match("/^http:\/\/([^\/]+)/i", $url, $matches);
        if (!empty($matches)) {
            $_url = parse_url($url);
            return $_url['host'].(isset($_url['port']) ? ":".$_url['port'] : "");
        }
        return $url;
    }

    public static function getSchemeAndHttpHost($urlStr)
    {
        $url = parse_url($urlStr);
        if (empty($url)) {
            return '';
        }
        return $url['scheme'].'://'.$url['host'].(isset($url['port']) ? ":".$url['port'] : "");
    }
}
