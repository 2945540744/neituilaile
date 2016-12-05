<?php

namespace Neitui\Dao\Impl;

use Neitui\Dao\CompanyDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class CompanyDaoImpl extends GeneralDaoImpl implements CompanyDao
{
    protected $table = 'n2_company';

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated')
        );
    }
}
