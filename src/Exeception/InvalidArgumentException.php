<?php
namespace Neitui\Exception;

class InvalidArgumentException extends BaseException
{
    public function __construct($message, $code = 0, array $headers = array())
    {
        parent::__construct(500, $message, null, $headers, $code);
    }
}
