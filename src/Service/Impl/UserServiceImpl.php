<?php

namespace Neitui\Service\Impl;

use Neitui\Common\ArrayToolkit;
use Neitui\Service\UserService;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class UserServiceImpl extends BaseService implements UserService
{
    public function getUser($id)
    {
        return $this->getUserDao()->get($id);
    }

    public function getUserByUsername($username)
    {
        return $this->getUserDao()->getByFields(array('username' => $username));
    }

    public function getCompanyByUserId($userId)
    {
        return $this->getCompanyDao()->getByUserId($userId);
    }

    public function getUserByWxUnionId($wid)
    {
        return $this->getUserDao()->getByFields(array('wx_unionid' => $wid));
    }

    //register from weixin
    public function register($user, $type)
    {
        $existed = $this->getUserDao()->getByWxUnionId($user['unionid']);
        if ($existed) {
            $existed['nickname'] = $user['nickname'];
            $existed['username'] = $user['nickname'];
            $existed['gender']   = $user['gender'] == 1 ? '男' : '女';
            $existed['avatar']   = $user['avatar'];
            $existed['updated']  = date('Y-m-d H:i:s');
            return $this->getUserDao()->update($existed['id'], $existed);
        }
        $new = array(
            'nickname'   => $user['nickname'],
            'username'   => $user['nickname'],
            'gender'     => $user['gender'],
            'avatar'     => $user['avatar'],
            'passwd'     => '111111',
            'wx_unionid' => $user['unionid']
        );
        $new['salt']   = md5(time().mt_rand(0, 1000));
        $new['passwd'] = $this->getPasswordEncoder()->encodePassword($new['passwd'], $new['salt']);
        if ($type == 'weixinmob') {
            $new['wx_mob'] = $user['openid'];
        } else {
            $new['wx_web'] = $user['openid'];
        }
        return $this->getUserDao()->create($new);
    }

    public function switchUserIdentity($userId, $identity)
    {
        $identity = strtoupper($identity);
        $user     = $this->getUser($userId);
        if ($user['current_identity'] === $identity) {
            return $user;
        }
        $user['current_identity'] = $identity;
        return $this->getUserDao()->update($userId, $user);
    }

    public function updateUser($id, $fields)
    {
        $fields = ArrayToolkit::parts($fields, array(
            'nickname',
            'gender',
            'edu_level',
            'exp_level',
            'birthday',
            'addr_city',
            'mobile',
            'email',
            'profile'
        ));

        return $this->getUserDao()->update($id, $fields);
    }

    public function saveEdu($userId, $edu)
    {
        $edu = ArrayToolkit::parts($edu, array(
            'school_name',
            'major_name',
            'start_date',
            'end_date',
            'edu_level'
        ));

        $existed = $this->getEducation($userId);
        if (!empty($existed)) {
            $edu = array_merge($existed, $edu);
        }

        if (!isset($edu['id'])) {
            $edu['member_id'] = $userId;
            $this->getUserEducationDao()->create($edu);
        } else {
            $this->getUserEducationDao()->update($edu['id'], $edu);
        }
    }

    public function saveExp($userId, $exp)
    {
        $exp = ArrayToolkit::parts($exp, array(
            'company_name',
            'position_name',
            'start_date',
            'end_date',
            'summary'
        ));
        //假设只有一份工作经历
        $existed = $this->getUserCompanyDao()->findByUserId($userId);
        if (!empty($existed)) {
            $exp = array_merge($existed[0], $exp);
        }

        if (!isset($exp['id'])) {
            $exp['member_id'] = $userId;
            $this->getUserCompanyDao()->create($exp);
        } else {
            $this->getUserCompanyDao()->update($exp['id'], $exp);
        }
    }

    //目前只录入用户的最高教育经历
    public function getEducation($userId)
    {
        $edus = $this->getUserEducationDao()->findByUserId($userId);
        if (!empty($edus)) {
            return $edus[0];
        }
        return array();
    }

    //用户的工作经历
    public function getExperiences($userId)
    {
        return $this->getUserCompanyDao()->findByUserId($userId);
    }

    protected function getUserDao()
    {
        return $this->kernel->dao('Neitui:UserDao');
    }

    protected function getCompanyDao()
    {
        return $this->kernel->dao('Neitui:CompanyDao');
    }

    protected function getUserCompanyDao()
    {
        return $this->kernel->dao('Neitui:UserCompanyDao');
    }

    protected function getUserEducationDao()
    {
        return $this->kernel->dao('Neitui:UserEducationDao');
    }

    private function getPasswordEncoder()
    {
        return new MessageDigestPasswordEncoder('sha256');
    }
}
