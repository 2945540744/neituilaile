<?php

namespace Neitui\Dao\Impl;

use Neitui\Dao\JobDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class JobDaoImpl extends GeneralDaoImpl implements JobDao
{
    protected $table = 'n2_job';

    public function searchJobs()
    {
        $sql = "SELECT j.*, c.short_name FROM n2_job j LEFT JOIN n2_company c ON j.company_id = c.id WHERE j.status <> '关闭' ORDER BY updated DESC limit 100";
        return $this->db()->fetchAll($sql, array());
    }

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated'),
            'orderbys'   => array('id')
        );
    }
}
