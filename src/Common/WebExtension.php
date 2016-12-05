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
            new \Twig_SimpleFunction('dict', array($this, 'getDictValue'))
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

    public function getName()
    {
        return "neitui_web_twig";
    }
}
