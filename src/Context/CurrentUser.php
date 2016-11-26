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
        return array('ROLE_USER');
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
        if ($this->email !== $user->getUsername()
            || array_diff($this->roles, $user->getRoles())
            || array_diff($user->getRoles(), $this->roles)) {
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
        if (array_key_exists($name, $this->fields)) {
            $this->fields[$name] = $value;
        }
        throw new \RuntimeException("fail to set : {$name} is not exist in CurrentUser.");
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
