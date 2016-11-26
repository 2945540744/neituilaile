<?php

namespace Neitui\Dao\Impl;

// use Neitui\Dao\UserDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class CompanyDaoImpl extends GeneralDaoImpl //implements UserDao
{
    protected $table = 'company';
    
    public function getCompanyIdByName($name = ''){
    	return $this->getByFields(array('real_name_full' => $name));
    }
    
    public function getInfoById($id = 0){
    	return $this->getByFields(array('id' => $id));
    }
    
    public function addCompanyInfo(array $data = []){
    	$company_id = 0;
    	if($data['real_name_full']){
    		$company_id = $this->getCompanyIdByName($data['real_name_full']);
    		if(!$company_id){
    			$this->create($data);
    		}
    	}
    	return $company_id;
    }

    public function declares()
    {
        return array(
//             'timestamps' => array('created', 'updated')
        );
    }
}
