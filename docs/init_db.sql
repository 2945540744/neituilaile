# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.12)
# Database: neitui
# Generation Time: 2016-12-05 14:28:12 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table n2_company
# ------------------------------------------------------------

DROP TABLE IF EXISTS `n2_company`;

CREATE TABLE `n2_company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '公司 ID',
  `full_name` varchar(255) NOT NULL DEFAULT '' COMMENT '公司全称',
  `short_name` varchar(255) NOT NULL DEFAULT '' COMMENT '公司简称',
  `website` varchar(255) NOT NULL DEFAULT '' COMMENT '公司官网',
  `found_date` date DEFAULT NULL COMMENT '成立时间',
  `certified` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否认证，0-否，1-是',
  `summary` text COMMENT '公司简介',
  `creator` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人 ID',
  `created` int(11) NOT NULL COMMENT '添加时间',
  `updator` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改人 ID',
  `updated` int(11) NOT NULL COMMENT '修改时间',
  `industry` varchar(100) NOT NULL DEFAULT '' COMMENT '行业',
  `scale` varchar(100) NOT NULL DEFAULT '' COMMENT '人员规模',
  `fund` varchar(50) NOT NULL DEFAULT '' COMMENT '融资阶段',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '公司地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标准公司表';



# Dump of table n2_resume
# ------------------------------------------------------------

DROP TABLE IF EXISTS `n2_resume`;

CREATE TABLE `n2_resume` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '简历 ID',
  `creator` int(11) NOT NULL DEFAULT '0' COMMENT '创建人',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '简历归属人 ID',
  `created` int(11) NOT NULL COMMENT '创建时间',
  `updator` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改人 ID',
  `updated` int(11) NOT NULL COMMENT '修改时间',
  `summary` text COMMENT '求职意向的补充说明',
  `intent_post` varchar(64) DEFAULT NULL COMMENT '意向职位',
  `work_type` int(11) DEFAULT NULL COMMENT '工作性质',
  `work_city` varchar(32) DEFAULT NULL COMMENT '意向工作城市',
  `intent_pay_from` int(11) DEFAULT NULL COMMENT '起薪',
  `intent_pay_to` int(11) DEFAULT NULL COMMENT '薪水上限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='简历表';



# Dump of table n2_resume_delivery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `n2_resume_delivery`;

CREATE TABLE `n2_resume_delivery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resume_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '简历 ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '投递人 ID',
  `delivery_time` int(11) NOT NULL COMMENT '投递时间',
  `delivery_company_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '投递到的公司 ID',
  `delivery_job_id` int(11) NOT NULL DEFAULT '0' COMMENT '投递',
  `deliver_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '投递状态，0-待投递，1-已投递',
  `receiver_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '受理状态，0-待受理，1-已受理',
  `process_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '处理状态，0-待处理，1-同意，2-拒绝，3-待定',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='简历投递记录';



# Dump of table n2_favorite
# ------------------------------------------------------------

DROP TABLE IF EXISTS `n2_favorite`;

CREATE TABLE `n2_favorite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏人 ID',
  `fav_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '信息类别，0-未知，1-岗位，2-简历',
  `fav_type_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '对应的信息 ID',
  `created` int(11) NOT NULL COMMENT '收藏时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收藏表';



# Dump of table n2_job
# ------------------------------------------------------------

DROP TABLE IF EXISTS `n2_job`;

CREATE TABLE `n2_job` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '岗位 ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '岗位名称',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '岗位所属公司 ID',
  `addr_province` varchar(32) DEFAULT '' COMMENT '岗位所在地：省',
  `addr_city` varchar(32) DEFAULT '' COMMENT '岗位所在地：市',
  `addr_area` varchar(64) DEFAULT '' COMMENT '岗位所在地：地区',
  `address` varchar(255) DEFAULT '' COMMENT '工作地点',
  `edu_level` tinyint(1) unsigned DEFAULT '0' COMMENT '学历要求，0-不限',
  `work_type` tinyint(1) unsigned DEFAULT '0' COMMENT '工作性质，0-不限，1-兼职，2-实习，3-全职',
  `exp_level` tinyint(1) unsigned DEFAULT '0' COMMENT '工作经验要求，0-不限',
  `summary_short` varchar(255) DEFAULT '' COMMENT '一句话简介',
  `summary` text COMMENT '岗位描述',
  `creator` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人ID',
  `created` int(11) NOT NULL COMMENT '创建时间',
  `updator` int(10) unsigned DEFAULT '0' COMMENT '修改人 ID',
  `updated` int(11) NOT NULL COMMENT '修改时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '岗位状态，0-草稿，1-开放，2-关闭',
  `finished_date` datetime DEFAULT NULL COMMENT '招聘结束时间',
  `pay_range_from` int(11) unsigned DEFAULT '1' COMMENT '薪资范围（起薪）',
  `pay_range_to` int(11) DEFAULT '1' COMMENT '薪资范围',
  `job_type` varchar(90) DEFAULT '' COMMENT '职位类型',
  `skills` text COMMENT '技能要求',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='岗位表';



# Dump of table n2_member
# ------------------------------------------------------------

DROP TABLE IF EXISTS `n2_member`;

CREATE TABLE `n2_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户 ID',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `passwd` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `slat` varchar(10) NOT NULL DEFAULT '' COMMENT '密码加强随机字串',
  `creator` int(11) NOT NULL DEFAULT '0' COMMENT '创建人 ID',
  `birthday` date DEFAULT NULL,
  `created` int(11) NOT NULL COMMENT '创建时间',
  `updator` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改人 ID',
  `updated` int(11) NOT NULL COMMENT '更新时间',
  `wx_unionid` varchar(60) NOT NULL DEFAULT '' COMMENT '微信 UNION ID',
  `wx_mob` varchar(60) NOT NULL DEFAULT '' COMMENT '外部 ID（微信）',
  `wx_web` varchar(60) NOT NULL DEFAULT '',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属公司 ID',
  `real_name` varchar(90) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别，0-保密，1-男，2-女',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号码',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT 'Email 地址',
  `addr_province` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '地址：所在省',
  `addr_city` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '地址：所在市',
  `addr_area` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '地址：所在地区',
  `summary` text COMMENT '个人简历',
  `avatar` varchar(512) DEFAULT '' COMMENT '头像地址',
  `nickname` varchar(90) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `profile` varchar(512) DEFAULT NULL COMMENT '一句话简介',
  `edu_level` int(11) DEFAULT NULL COMMENT '最高学历，0-未知，1-小学，2-初中，3-高中，4-中专，5-大学专科，6-大学本科，7-硕士，8-博士，9-其它',
  `exp_level` int(11) DEFAULT NULL COMMENT '工作经验，0-应届，1～10-相应年限，99-10 年以上',
  PRIMARY KEY (`id`),
  KEY `idx_u_union_id` (`wx_unionid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';



# Dump of table n2_member_company
# ------------------------------------------------------------

DROP TABLE IF EXISTS `n2_member_company`;

CREATE TABLE `n2_member_company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '详情 ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属人 ID',
  `company_name` varchar(255) NOT NULL DEFAULT '' COMMENT '公司名称',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联公司 ID',
  `work_start_date` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '工作开始日期，精确到月份',
  `work_end_date` smallint(4) NOT NULL DEFAULT '0' COMMENT '工作结束日期，精确到月份',
  `created` int(11) NOT NULL COMMENT '创建时间',
  `updated` int(11) NOT NULL COMMENT '修改时间',
  `position_name` varchar(255) NOT NULL DEFAULT '' COMMENT '职位名称',
  `position_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联标准职位 ID',
  `summary` text COMMENT '简介',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='简历详情（工作经历）';



# Dump of table n2_member_education
# ------------------------------------------------------------

DROP TABLE IF EXISTS `n2_member_education`;

CREATE TABLE `n2_member_education` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属用户 ID',
  `school_name` varchar(255) NOT NULL DEFAULT '' COMMENT '学校名称',
  `school_id` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '关联标准学校 ID',
  `major_name` varchar(255) NOT NULL DEFAULT '' COMMENT '所学专业名称',
  `major_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '关联标准专业 ID',
  `edu_start_date` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '学习开始日期，精确到月份',
  `edu_end_date` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '学习结束日期，精确到月份',
  `edu_level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '学历（参照个人学历的枚举）',
  `graduated_year` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '毕业年份',
  `created` int(11) NOT NULL COMMENT '创建时间',
  `updated` int(11) NOT NULL COMMENT '修改时间',
  `summary` varchar(512) DEFAULT NULL COMMENT '描述信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='简历详情（教育经历）';




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
