<?php

namespace Neitui\Service\Impl;

use Neitui\Common\ArrayToolkit;
use Codeages\Biz\Framework\Validation\Validator;

// use Neitui\Service\JobService;
// use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class JobServiceImpl extends BaseService//implements JobService

{
    public function getJob($id)
    {
        return $this->getJobDao()->get($id);
    }

    public function searchJobs()
    {
        return $this->getJobDao()->searchJobs();
    }

    public function findJobs($userId)
    {
        return $this->getJobDao()->findByUserId($userId);
    }

    public function createJob($job, $userId)
    {
        $job['creator'] = $userId;
        //create company
        $company = array();
        if (isset($job['company_id'])) {
            $company = $this->getCompanyDao()->get($job['company_id']);
        }
        //validate company
        $cvalidator = new Validator();
        if (!empty($company)) {
            $cvalidator->validate($job, array(
                'full_name'  => 'lenrange(2,30)',
                'short_name' => 'lenrange(2,10)',
                'industry'   => 'lenrange(1,20)',
                'scale'      => 'lenrange(1,20)',
                'fund'       => 'lenrange(1,20)',
                'website'    => 'lenrange(1,150)'
            ));
        } else {
            $cvalidator->validate($job, array(
                'full_name'  => 'required|lenrange(2,30)',
                'short_name' => 'required|lenrange(2,10)',
                'industry'   => 'required|lenrange(1,20)',
                'scale'      => 'required|lenrange(1,20)',
                'fund'       => 'required|lenrange(1,20)',
                'website'    => 'required|lenrange(1,150)'
            ));
        }
        //validate job
        $jvalidator = new Validator();
        $jvalidator->validate($job, array(
            'job_type'       => 'required|lenrange(2,30)',
            'title'          => 'required|lenrange(2,40)',
            // 'skills'         => 'required|lenrange(1,200)',
            'pay_range_from' => 'required|int|range(1,100)',
            'pay_range_to'   => 'required|int|range(1,100)',
            'exp_level'      => 'required|lenrange(1,50)',
            'edu_level'      => 'required|lenrange(1,50)',
            'addr_city'      => 'required|lenrange(1,50)',
            'address'        => 'required|lenrange(1,100)',
            'summary'        => 'lenrange(1,1000)'
        ));

        if ($cvalidator->fails()
            || $jvalidator->fails()
            || intval($job['pay_range_from']) > intval($job['pay_range_to'])) {
            throw $this->createInvalidArgumentException('参数有误');
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
            // 'skills',
            'pay_range_from',
            'pay_range_to',
            'exp_level',
            'edu_level',
            'addr_city',
            'address',
            'summary'
        ));

        $job['creator']    = $userId;
        $job['status']     = '开放';
        $job['company_id'] = $company['id'];

        return $this->getJobDao()->create($job);
    }

    public function updateJob($job, $userId)
    {
        //validate job
        $jvalidator = new Validator();
        $jvalidator->validate($job, array(
            'id'             => 'required|int',
            'job_type'       => 'required|lenrange(2,30)',
            'title'          => 'required|lenrange(2,40)',
            'skills'         => 'required|lenrange(1,200)',
            'pay_range_from' => 'required|range(1,100)',
            'pay_range_to'   => 'required|range(1,100)',
            'exp_level'      => 'required|lenrange(1,50)',
            'edu_level'      => 'required|lenrange(1,50)',
            'addr_city'      => 'required|lenrange(1,50)',
            'address'        => 'required|lenrange(1,100)',
            'summary'        => 'lenrange(1,1000)'
        ));

        if ($jvalidator->fails()) {
            throw $this->createInvalidArgumentException('参数有误');
        }

        $job['updator'] = $userId;

        return $this->getJobDao()->update($job['id'], $job);
    }

    public function deleteJob($jobId, $userId)
    {
        return $this->getJobDao()->delete($jobId);
    }

    public function closeJob($jobId, $userId)
    {
        return $this->getJobDao()->update($jobId, array('status' => '关闭'));
    }

    public function openJob($jobId, $userId)
    {
        return $this->getJobDao()->update($jobId, array('status' => '开放'));
    }

    public function getFavorites($userId)
    {
        return $this->getFavoriteDao()->getFavorites($userId);
    }

    public function isFavorited($jobId, $userId)
    {
        $fav = $this->getFavoriteDao()->getFavorite($jobId, $userId);
        return !empty($fav);
    }

    public function addFavorite($jobId, $userId)
    {
        $fav = $this->getFavoriteDao()->getFavorite($jobId, $userId);
        if (!empty($fav)) {
            throw new \Exception('职位已被收藏，不能重复收藏');
        }
        $fields = array(
            'member_id'   => $userId,
            'fav_type_id' => $jobId,
            'fav_type'    => 1
        );

        return $this->getFavoriteDao()->create($fields);
    }

    public function removeFavorite($jobId, $userId)
    {
        $fav = $this->getFavoriteDao()->getFavorite($jobId, $userId);
        if (empty($fav)) {
            throw new \Exception('您尚未收藏该职位');
        }
        return $this->getFavoriteDao()->delete($fav['id']);
    }

    public function getCompany($id)
    {
        return $this->getCompanyDao()->get($id);
    }

    protected function getJobDao()
    {
        return $this->kernel->dao('Neitui:JobDao');
    }

    protected function getFavoriteDao()
    {
        return $this->kernel->dao('Neitui:FavoriteDao');
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
