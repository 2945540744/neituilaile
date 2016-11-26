<?php

namespace Neitui\Service\Impl;

use Neitui\Service\UserService;

class UserServiceImpl extends BaseService implements UserService
{
    public function getUserByUsername($username)
    {
        return $this->getUserDao()->getByUsername($username);
    }

    public function getUserInfo(array $user_info = [], $type)
    {
        $tmp_user_info = $this->getUserDao()->getByWxUnionId($user_info['unionid']);
        
        $data['nickname']         = (string) $user_info['nickname'];
        $data['username']         = (string) $user_info['nickname'];
        $data['outer_wx_unionid'] = (string) $user_info['unionid'];
        $data['gender']           = (int) $user_info['gender'];
        $data['headimgurl']       = (string) $user_info['headimgurl'];
        $data['passwd']           = '111111';
        if($user_info['openid']){
        	if ($type == 'weixinmob') {
        		$data['outer_wx_mob'] = (string) $user_info['openid'];
        	} else {
        		$data['outer_wx_web'] = (string) $user_info['openid'];
        	}
        }
        if (empty($tmp_user_info)) {
        	$data['created']          = date('Y-m-d H:i:s');
            return $this->getUserDao()->addUser($data);
        }else{
        	$data['updated']          = date('Y-m-d H:i:s');
			$this->getUserDao()->update($tmp_user_info['id'],$data);        	
        }
        return $tmp_user_info;
    }

    public function createUser($user_info, $type)
    {
        $data_for_insert                     = array();
        $data_for_insert['nickname']         = $user_info['nickname'];
        $data_for_insert['created']          = date('Y-m-d H:i:s');
        $data_for_insert['outer_wx_unionid'] = $user_info['unionid'];
        $data_for_insert['gender']           = $user_info['sex'];
        $data_for_insert['headimgurl']       = $user_info['headimgurl'];
        if ($type == 'weixinmob') {
            $data_for_insert['outer_wx_mob'] = $user_info['openid'];
        } else {
            $data_for_insert['outer_wx_web'] = $user_info['openid'];
        }

        return $this->getUserDao()->create($data_for_insert);
    }

    public function createCompany($user_id = 0, array $info = []){
    	$data_for_insert = array();
    	$data_for_insert['owner_id'] = $user_id;
    	$data_for_insert['company_name'] = $info['company_name'];
    	$data_for_insert['position_name']= $info['position_name'];
    	$data_for_insert['summary'] = $info['summary'];
    	
    	$start = explode('-',$info['start']);
    	$data_for_insert['work_start_year'] = (int)$start[0];
    	$data_for_insert['work_start_month'] = min(12,(int)$start[1]);
    	
    	$end = explode('-',$info['end']);
    	$data_for_insert['work_end_year'] = (int)$end[0];
    	$data_for_insert['work_end_month'] = min(12,(int)$end[1]);
    	
    	$data_for_insert['created'] = $data_for_insert['updated'] = date('Y-m-d H:i:s');
    	return $this->getUserCompanyDao()->create($data_for_insert);
    }
    
    public function updateCompany($id = 0, array $info = []){
    	$data_for_update = [];
    	$data_for_update['company_name'] = $info['company_name'];
    	$data_for_update['position_name']= $info['position_name'];
    	$data_for_update['summary'] = $info['summary'];
    	
    	$start = explode('-',$info['start']);
    	$data_for_update['work_start_year'] = (int)$start[0];
    	$data_for_update['work_start_month'] = min(12,(int)$start[1]);
    	 
    	$end = explode('-',$info['end']);
    	$data_for_update['work_end_year'] = (int)$end[0];
    	$data_for_update['work_end_month'] = min(12,(int)$end[1]);
    	
    	$data_for_update['updated'] = date('Y-m-d H:i:s');
    	
    	return $this->getUserCompanyDao()->update($id,$data_for_update);
    }
    
    public function deleteCompany($id = 0, $user_id = 0){
    	$info = $this->getUserCompanyDao()->get($id);
    	if($info['owner_id'] && $info['owner_id']==$user_id){
    		return $this->getUserCompanyDao()->delete($id);
    	}
    	return false;
    }
    
    public function getCompanyById($id = 0, $user_id = 0){
    	$info = $this->getUserCompanyDao()->get($id);
    	if($info['owner_id'] && $info['owner_id']==$user_id){
    		return $info;
    	}
    	return [];
    }
    
    
    public function createEducation($user_id = 0, array $info = []){
    	$data_for_insert = [];
    	$data_for_insert['owner_id'] = $user_id;
    	$data_for_insert['school_name'] = $info['school_name'];
    	$data_for_insert['profession_name'] = $info['profession_name'];
    	$data_for_insert['edu_level'] = $info['edu_level'];
    	$data_for_insert['graduated_year'] = $info['graduated_year'];
    	
    	$data_for_insert['created'] = $data_for_insert['updated'] = date('Y-m-d H:i:s');
    	
    	$start = explode('-',$info['start']);
    	$data_for_insert['edu_start_year'] = (int)$start[0];
    	$data_for_insert['edu_start_month'] = min(12,(int)$start[1]);
    	
    	$end = explode('-',$info['end']);
    	$data_for_insert['edu_end_year'] = (int)$end[0];
    	$data_for_insert['edu_end_month'] = min(12,(int)$end[1]);
    	
    	return $this->getUserEducationDao()->create($data_for_insert);
    }
    
    public function updateEducation($id = 0, array $info = []){
    	$data_for_update = [];
    	$data_for_update['school_name'] = $info['school_name'];
    	$data_for_update['profession_name'] = $info['profession_name'];
    	$data_for_update['edu_level'] = $info['edu_level'];
    	$data_for_update['graduated_year'] = $info['graduated_year'];
    	
    	$start = explode('-',$info['start']);
    	$data_for_update['edu_start_year'] = (int)$start[0];
    	$data_for_update['edu_start_month'] = min(12,(int)$start[1]);
    	
    	$end = explode('-',$info['end']);
    	$data_for_update['edu_end_year'] = (int)$end[0];
    	$data_for_update['edu_end_month'] = min(12,(int)$end[1]);
    	 
    	$data_for_update['updated'] = date('Y-m-d H:i:s');
    	return $this->getUserCompanyDao()->update($id,$data_for_update);
    }
    
    public function getEducationById($id = 0, $user_id = 0){
    	$info = $this->getUserEducationDao()->get($id);
    	if($info['owner_id'] && $info['owner_id']==$user_id){
    		return $info;
    	}
    	return [];
    }
    
    protected function getUserDao()
    {
        return $this->kernel->dao('Neitui:UserDao');
    }
    
    protected function getUserCompanyDao(){
    	return $this->kernel->dao('Neitui:UserCompanyDao');
    }
    
    protected function getUserEducationDao(){
    	return $this->kernel->dao('Neitui:UserEducationDao');
    }

//     private function getPasswordEncoder()
    //     {
    //         return new MessageDigestPasswordEncoder('sha256');
    //     }
}
