<?php

namespace Neitui\Dao\Impl;

use Neitui\Dao\UserEducationDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserEducationDaoImpl extends GeneralDaoImpl implements UserEducationDao
{
    protected $table = 'n2_member_education';

    public function findByUserId($userId)
    {
        return $this->findInField('member_id', array($userId));
    }

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated'),
            'orderbys'   => array('edu_end_date')
        );
    }
}
