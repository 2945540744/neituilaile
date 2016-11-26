<?php

namespace Neitui\Dao\Impl;

// use Neitui\Dao\UserDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserDaoImpl extends GeneralDaoImpl//implements UserDao

{
    protected $table = 'member';

    public function getByUsername($username)
    {
        return $this->getByFields(array('username' => $username));
    }

    public function getByWxUnionId($wx_union_id = '')
    {
        return (array) $this->getByFields(array('outer_wx_unionid' => $wx_union_id));
    }

    public function getInfoById($id = '')
    {
        return $this->getByFields(array('id' => $id));
    }

    public function addUser(array $data = [])
    {
        return $this->create($data);
    }

    public function declares()
    {
        return array(
//             'timestamps' => array('created', 'updated')
        );
    }
}
