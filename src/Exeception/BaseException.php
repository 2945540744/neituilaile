<?php
namespace Neitui\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class BaseException extends HttpException
{
    public function __construct($statusCode, $message = null, \Exception $previous = null, array $headers = array(), $code = 0)
    {
        if (is_array($message) && count($message) >= 2 && is_array($message[1])) {
            $messageString = $message[0];
            if (isset($message[2]) && is_string($message[2])) {
                $messageString = $message[2].':'.$messageString;
            }
        } else {
            $messageString = $message;
        }
        parent::__construct($statusCode, $messageString, $previous, $headers, $code);
    }
}
