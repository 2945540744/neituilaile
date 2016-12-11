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

    public function findDeliveredResumes($companyId)
    {
        $sql = "SELECT d.id AS 'delivery_id', d.delivery_time,m.nickname,m.avatar, j.title AS 'job_title'  FROM n2_resume_delivery d
            LEFT JOIN n2_member m ON d.member_id = m.id
            LEFT JOIN n2_job j ON d.delivery_job_id = j.id
            WHERE d.delivery_company_id = ? ";
        return $this->db()->fetchAll($sql, array($companyId));
    }

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated'),
            'orderbys'   => array()
        );
    }
}
