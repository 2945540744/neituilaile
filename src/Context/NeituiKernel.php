<?php

namespace Neitui\Context;

use Codeages\Biz\Framework\Context\Biz;

class NeituiKernel extends Biz
{
    protected $mailer;

    public function mailer($mailer = null)
    {
        if ($mailer === null) {
            if ($this->mailer === null) {
                throw new \Exception("邮件服务尚未初始化。");
            }
            return $this->mailer;
        } else {
            $this->mailer = $mailer;
        }
    }
}
