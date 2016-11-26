<?php

namespace Neitui\Controller;

use Codeages\Biz\Framework\Context\Biz;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class BaseController
{
    protected $kernel;

    public function __construct(Biz $kernel)
    {
        $this->kernel = $kernel;
    }

    protected function getCurrentUser()
    {
        $this->kernel->user();
    }

    protected function jsonData($data)
    {
        if (empty($data)) {
            $data = array();
        }
        return new JsonResponse(array_merge(array('success' => true), $data));
    }

    protected function jsonSuccess()
    {
        return new JsonResponse(array('success' => true));
    }

    protected function jsonError($message, $code = 500)
    {
        return new JsonResponse(array('success' => false, 'error' => $code, 'message' => $message));
    }
}
