<?php

namespace Neitui\Dao\Impl;

use Neitui\Dao\UserDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserDaoImpl extends GeneralDaoImpl implements UserDao
{
    protected $table = 'n2_member';

    public function getByWxUnionId($wx_union_id = '')
    {
        return $this->getByFields(array('wx_unionid' => $wx_union_id));
    }

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated')
        );
    }
}
