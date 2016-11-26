<?php
namespace Neitui\Common;

use Gregwar\Captcha\CaptchaBuilder;

class CaptchaToolkit
{
    public static function create($width = 150, $height = 40, $font = null)
    {
        $builder = new CaptchaBuilder();
        $builder->build($width, $height, $font);

        return $builder;
    }
}
