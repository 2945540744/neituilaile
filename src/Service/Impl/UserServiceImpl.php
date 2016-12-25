<?php

namespace Neitui\Service\Impl;

use Neitui\Common\ArrayToolkit;
use Neitui\Service\UserService;
use Codeages\Biz\Framework\Validation\Validator;
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

    public function getCompany($id)
    {
        return $this->getCompanyDao()->get($id);
    }

    public function getCompanyByUserId($userId)
    {
        return $this->getCompanyDao()->getByUserId($userId);
    }

    public function getCompanyByJobId($jobId)
    {
        return $this->getCompanyDao()->getByJobId($jobId);
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
            $existed['username'] = $user['nickname'].'-'.time().mt_rand(0, 1000);
            $existed['gender']   = $user['gender'] == 1 ? '男' : '女';
            $existed['avatar']   = $user['avatar'];
            $existed['updated']  = date('Y-m-d H:i:s');
            return $this->getUserDao()->update($existed['id'], $existed);
        }
        $new = array(
            'nickname'   => $user['nickname'],
            'username'   => $user['nickname'].'-'.time().mt_rand(0, 1000),
            'gender'     => $user['gender'] == 1 ? '男' : '女',
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
        $validator = new Validator();
        $validator->validate($fields, array(
            'nickname'  => 'required|lenrange(2,40)',
            'gender'    => 'required|in("男","女")',
            'edu_level' => 'required|lenrange(1,50)',
            'exp_level' => 'required|lenrange(1,50)',
            'birthday'  => 'required|date',
            'addr_city' => 'required|lenrange(1,50)',
            'mobile'    => 'required|lenrange(1,100)',
            'email'     => 'required|lenrange(1,1000)',
            'profile'   => 'lenrange(1,200)'
        ));

        if ($validator->fails()) {
            return $this->createInvalidArgumentException('参数有误');
        }

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

    public function saveCompany($userId, $fields)
    {
        $validator = new Validator();
        $validator->validate($fields, array(
            'full_name'  => 'required|lenrange(2,100)',
            'short_name' => 'required|lenrange(1,100)',
            'industry'   => 'required|lenrange(1,50)',
            'scale'      => 'required|lenrange(1,50)',
            'fund'       => 'required|lenrange(1,50)',
            'profile'    => 'required|lenrange(1,200)',
            'address'    => 'required|lenrange(1,100)',
            'website'    => 'required|lenrange(1,200)',
            'summary'    => 'required|lenrange(1,2000)'
        ));

        if ($validator->fails()) {
            return $this->createInvalidArgumentException('参数有误');
        }

        $existed = $this->getCompanyByUserId($userId);
        if (!empty($existed)) {
            $fields = array_merge($existed, $fields);
        }
        if (isset($fields['id'])) {
            return $this->getCompanyDao()->update($fields['id'], $fields);
        } else {
            $fields['creator'] = $userId;
            return $this->getCompanyDao()->create($fields);
        }
    }

    public function saveEdu($userId, $edu)
    {
        $validator = new Validator();
        $validator->validate($edu, array(
            'school_name' => 'required|lenrange(2,100)',
            'major_name'  => 'required|lenrange(2,100)',
            'start_date'  => 'required|date("Y-m")',
            'end_date'    => 'required|date("Y-m")|after(start_date)',
            'edu_level'   => 'required|lenrange(1,50)'
        ));

        if ($validator->fails()) {
            return $this->createInvalidArgumentException('参数有误');
        }
        $edu = ArrayToolkit::parts($edu, array(
            'school_name',
            'major_name',
            'start_date',
            'end_date',
            'edu_level'
        ));
        if (!empty($edu['start_date'])) {
            $edu['start_date'] = date('Y-m-d', strtotime($edu['start_date']));
        }
        if (!empty($edu['end_date'])) {
            $edu['end_date'] = date('Y-m-d', strtotime($edu['end_date']));
        }

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
        $validator = new Validator();
        $validator->validate($exp, array(
            'company_name'  => 'required|lenrange(2,100)',
            'position_name' => 'required|lenrange(2,100)',
            'start_date'    => 'required|date("Y-m")',
            'end_date'      => 'required|date("Y-m")|after(start_date)',
            'summary'       => 'lenrange(1,1000)'
        ));

        if ($validator->fails()) {
            return $this->createInvalidArgumentException('参数有误');
        }
        $exp = ArrayToolkit::parts($exp, array(
            'company_name',
            'position_name',
            'start_date',
            'end_date',
            'summary'
        ));

        if (!empty($exp['start_date'])) {
            $exp['start_date'] = date('Y-m-d', strtotime($exp['start_date']));
        }
        if (!empty($exp['end_date'])) {
            $exp['end_date'] = date('Y-m-d', strtotime($exp['end_date']));
        }

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
