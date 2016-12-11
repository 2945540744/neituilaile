<?php

namespace Neitui\Service\Impl;

use Neitui\Common\ArrayToolkit;

// use Neitui\Service\JobService;
// use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class JobServiceImpl extends BaseService//implements JobService

{
    public function getJob($id)
    {
        return $this->getJobDao()->get($id);
    }

    public function findJobList($userId)
    {
        return $this->getJobDao()->findInField('creator', array($userId));
    }

    public function createJob($job, $userId)
    {
        $job['creator'] = $userId;
        //create company
        $company = array();
        if (isset($job['company_id'])) {
            $company = $this->getCompanyDao()->get($job['company_id']);
        }
        if (isset($job['full_name'])) {
            $company['full_name'] = $job['full_name'];
        }
        if (isset($job['short_name'])) {
            $company['short_name'] = $job['short_name'];
        }
        if (isset($job['industry'])) {
            $company['industry'] = $job['industry'];
        }
        if (isset($job['scale'])) {
            $company['scale'] = $job['scale'];
        }
        if (isset($job['fund'])) {
            $company['fund'] = $job['fund'];
        }
        if (isset($job['website'])) {
            $company['website'] = $job['website'];
        }
        if (isset($company['id'])) {
            $company['updator'] = $userId;
            $this->getCompanyDao()->update($company['id'], $company);
        } else {
            $company['creator'] = $userId;
            $company            = $this->getCompanyDao()->create($company);
            $job['company_id']  = $company['id'];
        }

        $job = ArrayToolkit::parts($job, array(
            'job_type',
            'title',
            'skills',
            'pay_range_from',
            'pay_range_to',
            'exp_level',
            'edu_level',
            'addr_city',
            'address',
            'summary'
        ));

        $job['creator'] = $userId;
        $job['status']  = '开放';

        return $this->getJobDao()->create($job);
    }

    public function updateJob($job, $userId)
    {
        $job['updator'] = $userId;

        return $this->getJobDao()->update($job['id'], $job);
    }

    public function deleteJob($jobId, $userId)
    {
        return $this->getJobDao()->delete($jobId);
    }

    public function closeJob($jobId, $userId)
    {
        //check if job exist
        return $this->getJobDao()->update($jobId, array('status' => '关闭'));
    }

    public function getCompany($id)
    {
        return $this->getCompanyDao()->get($id);
    }

    protected function getJobDao()
    {
        return $this->kernel->dao('Neitui:JobDao');
    }

    protected function getCompanyDao()
    {
        return $this->kernel->dao('Neitui:CompanyDao');
    }

    protected function getUserDao()
    {
        return $this->kernel->dao('Neitui:UserDao');
    }
}
