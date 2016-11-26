<?php

namespace Neitui\Service;

interface EmailService
{
    public function send($subject, $to, $content, $contentType = 'text/html');
}
