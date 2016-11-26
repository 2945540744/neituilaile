<?php

namespace Neitui\Service\Impl;

// use Neitui\Service\JobService;
// use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class JobServiceImpl extends BaseService//implements JobService

{
    public function getInfoById($id = 0)
    {
        return $this->getJobDao()->get($id);
    }

    public function addJob(array $data = [], $userid = 0)
    {
        $data_for_insert = array();

        $data_company                   = [];
        $data_company['real_name_full'] = $data['company_name'];
        $data_company['real_name_shot'] = $data['company_shortname'];
        $data_company['industry']       = $data['company_field'];
        $data_company['scale']          = $data['company_scale'];
        $data_company['fund']           = $data['company_fund'];
        $data_company['website']        = $data['company_site'];
        $data_company['creator_id']     = $userid;

        $data_for_insert['owner_company_id'] = (int) $this->getCompanyDao()->addCompanyInfo($data_company);
        $data_for_insert['job_title']        = $data['post_name'];
        $data_for_insert['job_type']         = $data['post_type'];
        $data_for_insert['skills']           = $data['post_skills'];
        $data_for_insert['pay_range_from']   = (int) $data['post_salary_min'];
        $data_for_insert['pay_range_to']     = (int) $data['post_salary_max'];
        $data_for_insert['experience_level'] = (int) $data['post_exp'];
        $data_for_insert['edu_level']        = (int) $data['post_cert'];

//         $data['post_city'];
        $data_for_insert['address'] = $data['post_address'];
        $data_for_insert['summary'] = $data['post_remark'];

        $data_for_insert['creator_id'] = $userid;
        $data_for_insert['created']    = date('Y-m-d H:i:s');

        return $this->getJobDao()->addJobInfo($data_for_insert);
    }

    public function editJob($id = 0, array $data = [], $userid = 0)
    {
        $data_for_update                     = [];
        $data_for_update['job_title']        = $data['post_name'];
        $data_for_update['job_type']         = $data['post_type'];
        $data_for_update['skills']           = $data['post_skills'];
        $data_for_update['pay_range_from']   = (int) $data['post_salary_min'];
        $data_for_update['pay_range_to']     = (int) $data['post_salary_max'];
        $data_for_update['experience_level'] = (int) $data['post_exp'];
        $data_for_update['edu_level']        = (int) $data['post_cert'];
        //         $data['post_city'];
        $data_for_update['address']    = $data['post_address'];
        $data_for_update['summary']    = $data['post_remark'];
        $data_for_update['updator_id'] = $userid;
        $data_for_update['updated']    = date('Y-m-d H:i:s');

        return $this->getJobDao()->editJobInfoById($id, $data_for_update);
    }

    public function viewJob($id = 0)
    {
        $job_info     = $this->getJobDao()->getInfoById($id);
        $company_info = $this->getCompanyDao()->getInfoById($job_info['owner_company_id']);
        $author_info  = $this->getUserDao()->getInfoById($job_info['creator_id']);
        return array(
            'job_info'     => $job_info,
            'company_info' => $company_info,
            'author_info'  => $author_info
        );
    }

    public function getJobList(array $condition = [])
    {
        return $this->getJobDao()->search($condition, array('id' => 'DESC'), 0, 100);
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
