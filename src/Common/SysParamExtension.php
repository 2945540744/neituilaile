<?php

namespace Neitui\Common;

class SysParamExtension extends \Twig_Extension
{
    public function __construct()
    {
    }

    public function getFilters()
    {
        return array(
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('sys_param', array($this, 'getSysParam'))
        );
    }

    public function getSysParam($key)
    {
        $parameters = require ROOT_DIR.'/config/parameters.php';
        if (isset($parameters[$key])) {
            return $parameters[$key];
        }
        //or throw exception ?
        return null;
    }

    public function getName()
    {
        return "neitui_sys_param_twig";
    }
}
