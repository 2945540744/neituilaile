<?php

namespace Neitui\Dao\Impl;

use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserCompanyDaoImpl extends GeneralDaoImpl//implements UserDao

{
    protected $table = 'n2_member_company';

    public function findByUserId($userId)
    {
        return $this->findInField('member_id', array($userId));
    }

    public function declares()
    {
        return array(
            'timestamps' => array('created', 'updated'),
            'orderbys'   => array('work_end_date')
        );
    }
}

// CREATE TABLE `member_detail_company` (
//         `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '详情 ID',
//         `owner_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属人 ID',
//         `company_name` char(255) NOT NULL DEFAULT '' COMMENT '公司名称',
//         `std_company_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联公司 ID',
//         `work_start_year` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '工作开始年份',
//         `work_start_month` tinyint(2) NOT NULL DEFAULT '1' COMMENT '工作开始',
//         `work_end_year` smallint(4) NOT NULL DEFAULT '0' COMMENT '工作开始',
//         `work_end_month` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '工作结束月份',
//         `created` char(19) NOT NULL DEFAULT '' COMMENT '创建时间',
//         `updated` char(19) NOT NULL DEFAULT '' COMMENT '修改时间',
//         `position_name` char(255) NOT NULL DEFAULT '' COMMENT '职位名称',
//         `std_position_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联标准职位 ID',
//         `summary` text COMMENT '简介',
//         PRIMARY KEY (`id`)
//         ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='简历详情（工作经历）'
