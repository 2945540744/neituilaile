<?php
namespace Neitui\Context;

use Symfony\Component\Security\Core\User\UserInterface;
use Codeages\Biz\Framework\Context\CurrentUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class CurrentUser implements CurrentUserInterface, UserInterface, AdvancedUserInterface, EquatableInterface, \ArrayAccess
{
    protected $fields;

    public function __construct($fields)
    {
        $fields['enabled'] = true;
        $this->fields      = $fields;
    }

    public function getRoles()
    {
        if (!empty($this->roles)) {
            if (is_string($this->roles)) {
                return json_decode($this->roles, true);
            }
            return $this->roles;
        }
        //说明：
        //1. 'ROLE_USER'和'ROLE_ADMIN'表达普通用户和超管；
        //2. 'RECRUITER'和'JOBHUNTER'表达招聘者和求职者身份；每个用户都可以拥有此两种身份，但不能同时使用
        return array('ROLE_USER');
    }

    public function getCurrentIdentity()
    {
        if (!empty($this->fields['current_identity'])) {
            return $this->fields['current_identity'];
        }
        return 'JOBHUNTER';
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return true;
    }

    public function isEqualTo(UserInterface $user)
    {
        if (array_diff($this->getRoles(), $user->getRoles())
            || array_diff($user->getRoles(), $this->getRoles())) {
            return false;
        }

        return true;
    }

    public function isLogin()
    {
        return !empty($this->id);
    }

    public function __set($name, $value)
    {
        // if (array_key_exists($name, $this->fields)) {
        $this->fields[$name] = $value;
        // }
        // throw new \RuntimeException("fail to set : {$name} is not exist in CurrentUser.");
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[$name];
        }
        return null;
        // throw new \RuntimeException("fail to get : {$name} is not exist in CurrentUser.");
    }

    public function __isset($name)
    {
        return isset($this->fields[$name]);
    }

    public function __unset($name)
    {
        unset($this->fields[$name]);
    }

    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->__set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        return $this->__unset($offset);
    }
}
