<?php

namespace Neitui\Service\Impl;

use Codeages\Biz\Framework\Context\Biz;
use Codeages\Biz\Framework\Service\Exception\ServiceException;
use Codeages\Biz\Framework\Service\Exception\NotFoundException;
use Codeages\Biz\Framework\Service\Exception\AccessDeniedException;
use Codeages\Biz\Framework\Service\Exception\InvalidArgumentException;

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

    /**
     * @param  string                  $message
     * @return AccessDeniedException
     */
    protected function createAccessDeniedException($message = '')
    {
        return new AccessDeniedException($message);
    }

    /**
     * @param  string                     $message
     * @return InvalidArgumentException
     */
    protected function createInvalidArgumentException($message = '')
    {
        return new InvalidArgumentException($message);
    }

    /**
     * @param  string              $message
     * @return NotFoundException
     */
    protected function createNotFoundException($message = '')
    {
        return new NotFoundException($message);
    }

    /**
     * @param  string             $message
     * @return ServiceException
     */
    protected function createServiceException($message = '')
    {
        return new ServiceException($message);
    }

}
