<?php
namespace Neitui\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends ServiceAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('init')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = array(
            'username' => '系统管理员',
            'email'    => 'ahun@neituixwz.com',
            'passwd'   => 'ntxwz123456',
            'roles'    => '["ROLE_ROOT"]'
        );

        $output->writeln("初始化系统管理员：");

        $registed = $this->kernel->dao('Neitui:UserService')->register($user);

        $output->writeln("  用户名：{$registed['username']}");
        $output->writeln("  邮箱：{$registed['email']}");
        $output->writeln("  密码：{$user['passwd']}");

    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
    }
}
