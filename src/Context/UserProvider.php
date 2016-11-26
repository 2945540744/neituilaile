<?php
namespace Neitui\Context;

use Neitui\Context\LogFactory;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserProvider implements UserProviderInterface
{
    protected $kernel;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->getUserService()->getUserByUsername($username);
        if (empty($user)) {
            throw new UsernameNotFoundException(sprintf('用户 "%s" 不存在.', $username));
        }

        $currentUser = new CurrentUser($user);
        return $currentUser;
    }

    public function refreshUser(UserInterface $user)
    {
        LogFactory::getLogger('UserProvider')->debug('refreshUser : '.json_encode($user));
        if (!$user instanceof CurrentUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        return $this->loadUserByUsername($user['username']);
    }

    public function supportsClass($class)
    {
        return $class === 'Neitui\Context\CurrentUser';
    }

    protected function getUserService()
    {
        return $this->kernel->service('Neitui:UserService');
    }
}
