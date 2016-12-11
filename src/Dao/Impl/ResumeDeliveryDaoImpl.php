<?php

namespace Neitui\Dao\Impl;

use Neitui\Dao\ResumeDeliveryDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class ResumeDeliveryDaoImpl extends GeneralDaoImpl implements ResumeDeliveryDao
{
    protected $table = 'n2_resume_delivery';

    public function getByUserIdAndJobId($userId, $jobId)
    {
        return $this->getByFields(array('member_id' => $userId, 'delivery_job_id' => $jobId));
    }

    public function declares()
    {
        return array(
            'timestamps' => array('delivery_time')
        );
    }
}
