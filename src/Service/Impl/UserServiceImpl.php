<?php

namespace Neitui\Service\Impl;

use Neitui\Service\UserService;

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
            $existed['gender']   = $user['gender'];
            $existed['avatar']   = $user['avatar'];
            $existed['updated']  = date('Y-m-d H:i:s');
            var_dump($user);
            var_dump($existed);
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
        if ($type == 'weixinmob') {
            $new['wx_mob'] = $user['openid'];
        } else {
            $new['wx_web'] = $user['openid'];
        }
        return $this->getUserDao()->create($new);
    }

    //目前只录入用户的最高教育经历
    public function getEducation($userId)
    {
        return $this->getUserEducationDao()->findByUserId($userId);
    }

    //用户的工作经历
    public function getCompanies($userId)
    {
        return $this->getUserCompanyDao()->findByUserId($userId);
    }

    protected function getUserDao()
    {
        return $this->kernel->dao('Neitui:UserDao');
    }

    protected function getUserCompanyDao()
    {
        return $this->kernel->dao('Neitui:UserCompanyDao');
    }

    protected function getUserEducationDao()
    {
        return $this->kernel->dao('Neitui:UserEducationDao');
    }

//     private function getPasswordEncoder()
    //     {
    //         return new MessageDigestPasswordEncoder('sha256');
    //     }
}
