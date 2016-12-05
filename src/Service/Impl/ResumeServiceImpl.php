<?php

namespace Neitui\Service\Impl;

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

    public function getResumeInfo($userId = 0)
    {
        return $this->getResumeDao()->getResumeByUserId($userId);
    }

    public function createResume($userId = 0, array $info = [])
    {
        $info = $this->getResumeDao()->getResumeByUserId($userId);
        if (!$info) {
            $data                 = [];
            $data['owner_id']     = $userId;
            $data['edu_level']    = $info['edu_level'];
            $data['worked_level'] = $info['worked_level'];
            $data['summary']      = $info['summary'];
            return $this->getResumeDao()->create($data);
        }
        return (int) $info['id'];
    }

    public function updateResume($id = 0, array $info = [], $user_id = 0)
    {
        $info = $this->getResumeDao()->get($id);
        if ($info['owner_id'] && $info['owner_id'] == $user_id) {
            $data                 = [];
            $data['edu_level']    = $info['edu_level'];
            $data['worked_level'] = $info['worked_level'];
            $data['summary']      = $info['summary'];
            return $this->getResumeDao()->update($id, $data);
        }
        return false;
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
