<?php

namespace Neitui\Service\Impl;

use Neitui\Common\ArrayToolkit;

class ResumeServiceImpl extends BaseService
{
    public function getResume($id)
    {
        return $this->getResumeDao()->get($id);
    }

    public function getResumeByUserId($userId)
    {
        return $this->getResumeDao()->getByUserId($userId);
    }

    public function saveResume($userId, $resume)
    {
        $resume = ArrayToolkit::parts($resume, array(
            'post_name',
            'job_type',
            'addr_city',
            'pay_range_from',
            'pay_range_to',
            'summary',
            'on_the_job'
        ));
        $existed = $this->getResumeByUserId($userId);
        if (!empty($existed)) {
            $resume = array_merge($existed, $resume);
        }

        if (!isset($resume['id'])) {
            $resume['member_id'] = $userId;
            $this->getResumeDao()->create($resume);
        } else {
            $this->getResumeDao()->update($resume['id'], $resume);
        }
    }

    protected function getResumeDao()
    {
        return $this->kernel->dao('Neitui:ResumeDao');
    }

    protected function getUserCompanyDao()
    {
        return $this->kernel->dao('Neitui:UserCompanyDao');
    }

    protected function getUserEducationDao()
    {
        return $this->kernel->dao('Neitui:UserEducationDao');
    }
}
