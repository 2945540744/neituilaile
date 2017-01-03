<?php

namespace Neitui\Service\Impl;

use Neitui\Common\ArrayToolkit;
use Codeages\Biz\Framework\Validation\Validator;

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

    public function findDeliveredResumes($companyId)
    {
        return $this->getResumeDao()->findDeliveredResumes($companyId);
    }

    public function saveResume($userId, $resume)
    {
        $validator = new Validator();
        $validator->validate($resume, array(
            'job_type'       => 'required|lenrange(2,30)',
            'post_name'      => 'required|lenrange(2,40)',
            'pay_range_from' => 'required|range(1,100)',
            'pay_range_to'   => 'required|range(1,100)',
            'addr_city'      => 'required|lenrange(1,50)',
            'on_the_job'     => 'required|bool',
            'summary'        => 'lenrange(1,1000)'
        ));

        if ($validator->fails() || intval($resume['pay_range_from']) > intval($resume['pay_range_to'])) {
            throw $this->createInvalidArgumentException('参数有误');
        }
        $resume = ArrayToolkit::parts($resume, array(
            'id',
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

    public function deliveryResume($jobId, $userId)
    {
        $existed = $this->getResumeDeliveryDao()->getByUserIdAndJobId($userId, $jobId);
        if ($existed) {
            throw new \Exception('用户#{$userId}已投递过职位#{$jobId}');
        }
        $resume = $this->getResumeByUserId($userId);
        $job    = $this->getJobDao()->get($jobId);
        $fields = array(
            'resume_id'           => $resume['id'],
            'member_id'           => $userId,
            // 'delivery_time'       => time(),
            'delivery_company_id' => $job['company_id'],
            'delivery_job_id'     => $jobId,
            'deliver_status'      => '已投递',
            'receiver_status'     => '已受理',
            'process_status'      => '待处理'
        );

        return $this->getResumeDeliveryDao()->create($fields);
    }

    public function getDeliveryRecord($jobId, $userId)
    {
        return $this->getResumeDeliveryDao()->getByUserIdAndJobId($userId, $jobId);
    }

    protected function getResumeDao()
    {
        return $this->kernel->dao('Neitui:ResumeDao');
    }

    protected function getResumeDeliveryDao()
    {
        return $this->kernel->dao('Neitui:ResumeDeliveryDao');
    }

    protected function getUserCompanyDao()
    {
        return $this->kernel->dao('Neitui:UserCompanyDao');
    }

    protected function getUserEducationDao()
    {
        return $this->kernel->dao('Neitui:UserEducationDao');
    }

    protected function getUserService()
    {
        return $this->kernel->service('Neitui:UserService');
    }

    protected function getJobDao()
    {
        return $this->kernel->dao('Neitui:JobDao');
    }
}
