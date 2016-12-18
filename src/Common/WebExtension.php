<?php

namespace Neitui\Common;

class WebExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('dict', array($this, 'getDictValue')),
            new \Twig_SimpleFunction('age', array($this, 'calcAge')),
            new \Twig_SimpleFunction('month', array($this, 'month'))
        );
    }

    public function getDictValue($key, $dict)
    {
        $dicts = require ROOT_DIR.'/config/dicts.php';
        if (isset($dicts[$dict])) {
            return $dicts[$dict][$key];
        }
        return null;
    }

    public function calcAge($date)
    {
        if (empty($date)) {
            return '';
        }

        return ((int) date('Y', time()) - (int) substr($date, 0, 4)).'岁';
    }

    public function month($date, $fmt = 'Y/m')
    {
        if (empty($date)) {
            return '';
        }

        return date($fmt, strtotime($date));
    }

    public function getName()
    {
        return "neitui_web_twig";
    }
}
