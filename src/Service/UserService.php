<?php

namespace Neitui\Service;

interface UserService
{
    public function getUser($id);

    public function getUserByUsername($username);

    public function getCompany($id);

    public function getCompanyByUserId($userId);

    public function getCompanyByJobId($jobId);

    public function getUserByWxUnionId($wid);

    public function register($user, $type);

    public function switchUserIdentity($userId, $identity);

    public function updateUser($id, $fields);

    public function saveEdu($userId, $edu);

    public function saveExp($userId, $exp);

    //目前只录入用户的最高教育经历
    public function getEducation($userId);

    //用户的工作经历
    public function getExperiences($userId);
}
