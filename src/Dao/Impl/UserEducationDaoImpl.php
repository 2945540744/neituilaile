<?php

namespace Neitui\Dao\Impl;

use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserEducationDaoImpl extends GeneralDaoImpl//implements UserDao

{
    protected $table = 'member_detail_education';
    
    
    public function declares()
    {
        return array(
//             'timestamps' => array('created', 'updated')
        );
    }
    
    
    
    
    
//     search($conditions, $orderbys, $start, $limit)
    
}

// CREATE TABLE `member_detail_education` (
// 		`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
// 		`owner_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属用户 ID',
// 		`school_name` char(255) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '学校名称',
// 		`std_school_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '关联标准学校 ID',
// 		`profession_name` char(255) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '所学专业名称',
// 		`std_profession_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '关联标准专业 ID',
// 		`edu_start_year` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '学习开始年份',
// 		`edu_start_month` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '学习开始月份',
// 		`edu_end_year` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '学习结束年份',
// 		`edu_end_month` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '学习结束月份',
// 		`edu_level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '学历（参照个人学历的枚举）',
// 		`graduated_year` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '毕业年份',
// 		`created` char(19) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '创建时间',
// 		`updated` char(19) CHARACTER SET latin1 NOT NULL DEFAULT '' COMMENT '修改时间',
// 		PRIMARY KEY (`id`)
// 		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='简历详情（教育经历）'