<?php

namespace Neitui\Dao\Impl;

use Neitui\Dao\ResumeDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class ResumeDaoImpl extends GeneralDaoImpl implements ResumeDao
{
    protected $table = 'n2_resume';

    public function getByUserId($userId)
    {
        return $this->getByFields(array('member_id' => $userId));
    }

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated'),
            'orderbys'   => array()
        );
    }
}
