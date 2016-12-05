<?php

namespace Neitui\Dao\Impl;

// use Neitui\Dao\UserDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class JobDaoImpl extends GeneralDaoImpl//implements UserDao

{
    protected $table = 'n2_job';

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated'),
            'orderbys'   => array('id')
        );
    }
}
