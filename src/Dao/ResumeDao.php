<?php

namespace Neitui\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface ResumeDao extends GeneralDaoInterface
{
    public function getResumeByUserId($user_id = 0){
    	return (array) $this->getByFields(array('owner_id' => $user_id));
    }
    
    
}


// CREATE TABLE `cv` (
// 		`id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '简历 ID',
// 		`creator_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建人',
// 		`owner_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '简历归属人 ID',
// 		`created` char(19) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '创建时间',
// 		`updator_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改人 ID',
// 		`updated` char(19) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '修改时间',
// 		`edu_level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '最高学历，0-未知，1-小学，2-初中，3-高中，4-中专，5-大学专科，6-大学本科，7-硕士，8-博士，9-其它',
// 		`worked_level` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '工作经验，0-应届，1～10-相应年限，99-10 年以上',
// 		PRIMARY KEY (`id`)
// 		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='简历表'