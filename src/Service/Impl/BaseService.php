<?php

namespace Neitui\Service\Impl;

use Codeages\Biz\Framework\Context\Biz;

class BaseService extends \Codeages\Biz\Framework\Service\BaseService
{
    protected $kernel;

    public function __construct(Biz $kernel)
    {
        $this->kernel = $kernel;
    }

    protected function getCurrentUser()
    {
        return $this->kernel->user();
    }

}
