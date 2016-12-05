<?php

namespace Neitui\Context;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class NLogger
{
    public static function getLogger($name)
    {
        $logger = new Logger($name);
        $logger->pushHandler(new StreamHandler(ROOT_DIR.'/var/logs/service.log', Logger::DEBUG));

        return $logger;
    }

}
