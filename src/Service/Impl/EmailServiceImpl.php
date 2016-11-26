<?php

namespace Neitui\Service\Impl;

use Neitui\Service\EmailService;

class EmailServiceImpl extends BaseService implements EmailService
{
    public function send($subject, $to, $content, $contentType = 'text/html')
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom(array(EMAIL_FROM))
            ->setTo(array($to))
            ->setBody($content, $contentType);

        $this->mailer()->send($message);
    }

    protected function mailer()
    {
        return $this->kernel->mailer();
    }
}
