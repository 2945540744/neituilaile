<?php
namespace Neitui\Command;

use Symfony\Component\Console\Command\Command;

class ServiceAwareCommand extends Command
{
    protected $kernel;

    public function __construct($kernel)
    {
        parent::__construct();
        $this->kernel = $kernel;
    }

}
