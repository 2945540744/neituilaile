<?php

namespace Neitui\Context;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LogFactory
{
    private static $loggers = array();

    public static function getLogger($name, $level = Logger::INFO)
    {
        if (isset(LogFactory::$loggers[$name])) {
            return LogFactory::$loggers[$name];
        }

        $logger = new Logger($name);
        $logger->pushHandler(new StreamHandler(ROOT_DIR.'/var/logs/service.log', $level)); //Logger::DEBUG
        LogFactory::$loggers[$name] = $logger;

        return $logger;
    }
}
