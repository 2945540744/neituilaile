# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.12)
# Database: neitui
# Generation Time: 2016-12-11 11:21:42 +0000
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

LOCK TABLES `n2_company` WRITE;
/*!40000 ALTER TABLE `n2_company` DISABLE KEYS */;

INSERT INTO `n2_company` (`id`, `full_name`, `short_name`, `website`, `found_date`, `certified`, `summary`, `creator`, `created`, `updator`, `updated`, `industry`, `scale`, `fund`, `address`)
VALUES
  (5,'Google inc','airing.io','wwww.google.com',NULL,0,NULL,0,1480942182,0,1480942182,'IT','110032','dsaf',''),
  (6,'都会狠狠的把很多','焦恩俊','嗯很神经',NULL,0,NULL,46,1481025751,0,1481025751,'很多','2993938','喝喝酒',''),
  (7,'杭州老司机科技有限公司','内推小王子','www.neituilaile.com',NULL,0,NULL,48,1481434230,0,1481434230,'互联网','10','天使',''),
  (8,'杭州老司机科技有限公司','内推小王子','www.neituilaile.com',NULL,0,NULL,49,1481448685,0,1481448685,'互联网','10','天使轮',''),
  (9,'杭州老司机科技有限公司','产品经理','www.neituilaile.com',NULL,0,NULL,49,1481451573,0,1481451573,'互联网','10','天使','');

/*!40000 ALTER TABLE `n2_company` ENABLE KEYS */;
UNLOCK TABLES;


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
  `addr_province` varchar(64) DEFAULT '' COMMENT '岗位所在地：省',
  `addr_city` varchar(64) DEFAULT '' COMMENT '岗位所在地：市',
  `addr_area` varchar(64) DEFAULT '' COMMENT '岗位所在地：地区',
  `address` varchar(255) DEFAULT '' COMMENT '工作地点',
  `edu_level` varchar(32) DEFAULT '0' COMMENT '学历要求，0-不限',
  `work_type` varchar(32) DEFAULT '0' COMMENT '工作性质，0-不限，1-兼职，2-实习，3-全职',
  `exp_level` varchar(32) DEFAULT '0' COMMENT '工作经验要求，0-不限',
  `summary_short` varchar(255) DEFAULT '' COMMENT '一句话简介',
  `summary` text COMMENT '岗位描述',
  `creator` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建人ID',
  `created` int(11) NOT NULL COMMENT '创建时间',
  `updator` int(10) unsigned DEFAULT '0' COMMENT '修改人 ID',
  `updated` int(11) NOT NULL COMMENT '修改时间',
  `status` varchar(32) NOT NULL DEFAULT '0' COMMENT '岗位状态，0-草稿，1-开放，2-关闭',
  `finished_date` datetime DEFAULT NULL COMMENT '招聘结束时间',
  `pay_range_from` int(11) unsigned DEFAULT '1' COMMENT '薪资范围（起薪）',
  `pay_range_to` int(11) DEFAULT '1' COMMENT '薪资范围',
  `job_type` varchar(64) DEFAULT '' COMMENT '职位类型',
  `skills` text COMMENT '技能要求',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='岗位表';

LOCK TABLES `n2_job` WRITE;
/*!40000 ALTER TABLE `n2_job` DISABLE KEYS */;

INSERT INTO `n2_job` (`id`, `title`, `company_id`, `addr_province`, `addr_city`, `addr_area`, `address`, `edu_level`, `work_type`, `exp_level`, `summary_short`, `summary`, `creator`, `created`, `updator`, `updated`, `status`, `finished_date`, `pay_range_from`, `pay_range_to`, `job_type`, `skills`)
VALUES
  (2,'title--sdafds',5,'','hz','','hangzhoudaxuecheng ','3','0','3','','dsafdsdsafds',46,1480942182,46,1480942760,'0',NULL,1,6,'运维','php,java,sfd'),
  (3,'还得喝喝酒',0,'','hz','','嗯很神经','2','0','4','','度假酒店及度假酒店介绍呢',46,1481025751,0,1481025751,'0',NULL,6,7,'运维','人家家v 度假酒店'),
  (4,'前端工程师',0,'','北京','','南环路4179号','不限','0','不限','','1、我误会误会我\r\n2.是计算机上',48,1481434230,0,1481434230,'0',NULL,13,9,'前端开发','1、哈哈哈哈 2、呵呵呵'),
  (5,'PHP工程师',0,'','上海','','杭州','不限','0','不限','','哈哈哈哈哈哈哈哈啊',49,1481448685,49,1481450704,'',NULL,5,15,'前端开发','无'),
  (6,'产品经理',0,'','上海','','','不限','0','不限','','产品经理',49,1481451573,0,1481451680,'关闭',NULL,1,5,'测试','');

/*!40000 ALTER TABLE `n2_job` ENABLE KEYS */;
UNLOCK TABLES;


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
  `gender` varchar(10) NOT NULL DEFAULT '男' COMMENT '性别：保密、男、女',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号码',
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT 'Email 地址',
  `addr_province` varchar(64) NOT NULL DEFAULT '0' COMMENT '地址：所在省',
  `addr_city` varchar(64) NOT NULL DEFAULT '0' COMMENT '地址：所在市',
  `addr_area` varchar(64) NOT NULL DEFAULT '0' COMMENT '地址：所在地区',
  `summary` text COMMENT '个人简历',
  `avatar` varchar(512) DEFAULT '' COMMENT '头像地址',
  `nickname` varchar(90) DEFAULT '' COMMENT '微信昵称',
  `profile` varchar(512) DEFAULT NULL COMMENT '一句话简介',
  `edu_level` varchar(32) DEFAULT NULL COMMENT '最高学历：小学、初中、高中、中专、专科、本科、硕士、博士、其它',
  `exp_level` varchar(32) DEFAULT NULL COMMENT '工作经验：应届、X年、10 年以上',
  `current_identity` varchar(32) DEFAULT 'JOBHUNTER' COMMENT '当前身份：JOBHUNTER, RECRUITER',
  PRIMARY KEY (`id`),
  KEY `idx_u_union_id` (`wx_unionid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

LOCK TABLES `n2_member` WRITE;
/*!40000 ALTER TABLE `n2_member` DISABLE KEYS */;

INSERT INTO `n2_member` (`id`, `username`, `passwd`, `slat`, `creator`, `birthday`, `created`, `updator`, `updated`, `wx_unionid`, `wx_mob`, `wx_web`, `company_id`, `real_name`, `gender`, `mobile`, `email`, `addr_province`, `addr_city`, `addr_area`, `summary`, `avatar`, `nickname`, `profile`, `edu_level`, `exp_level`, `current_identity`)
VALUES
  (46,'马若智','111111','',0,'1989-09-03',1481433977,0,1481453630,'ojz3jvpRvN7uDreqEU8qORvmamVk','','oszgZwcjx3d_kCT8NjK5akufon9o',0,'','男','','','0','北京','0',NULL,'http://wx.qlogo.cn/mmopen/D5psPORib1XYAAsfwBIsznXHaguqRecWzH0U5n5hFmcjo3Vaqa0OXNPvUB6o42YU4Z2B1ONrRlEC5hvm28iaF4fj4er0sXCgtZ/0','马若智','','高中','在读','JOBHUNTER'),
  (49,'阿混','111111','',0,NULL,1481448519,0,1481454996,'ojz3jvs-WqNXBM38gAM41tO5R7w8','','oszgZwT9mQZG8Eadl6ttsA1bLXFc',0,'','男','','','0','0','0',NULL,'http://wx.qlogo.cn/mmopen/QHl3tULqJy0ddeJsN023hQ8YM3JZJjaiap5gBVmDhnlMiaA2cr1vujeBldEYrCKMOqjlcj0iajukrBEGIDblUzzM6q4V9mqoXqg/0','阿混',NULL,NULL,NULL,'RECRUITER');

/*!40000 ALTER TABLE `n2_member` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table n2_member_company
# ------------------------------------------------------------

DROP TABLE IF EXISTS `n2_member_company`;

CREATE TABLE `n2_member_company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '详情 ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属人 ID',
  `company_name` varchar(255) NOT NULL DEFAULT '' COMMENT '公司名称',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联公司 ID',
  `start_date` date DEFAULT NULL COMMENT '工作开始日期，精确到月份',
  `end_date` date DEFAULT NULL COMMENT '工作结束日期，精确到月份',
  `created` int(11) NOT NULL COMMENT '创建时间',
  `updated` int(11) NOT NULL COMMENT '修改时间',
  `position_name` varchar(255) NOT NULL DEFAULT '' COMMENT '职位名称',
  `position_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联标准职位 ID',
  `summary` text COMMENT '简介',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='简历详情（工作经历）';

LOCK TABLES `n2_member_company` WRITE;
/*!40000 ALTER TABLE `n2_member_company` DISABLE KEYS */;

INSERT INTO `n2_member_company` (`id`, `member_id`, `company_name`, `company_id`, `start_date`, `end_date`, `created`, `updated`, `position_name`, `position_id`, `summary`)
VALUES
  (4,46,'Google Inc',0,'2015-01-20','2016-10-12',1481029776,1481031156,'CEO1',0,'本文是音频处理的朋友icoolmedia（QQ：314138065）的投稿。对音频处理有兴趣的朋友可以通过下面的方式与他交流：作者：icoolmedia QQ：314138065 音视频算法讨论QQ群：374737122 原文公式较多，因此直接贴上图片');

/*!40000 ALTER TABLE `n2_member_company` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table n2_member_education
# ------------------------------------------------------------

DROP TABLE IF EXISTS `n2_member_education`;

CREATE TABLE `n2_member_education` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属用户 ID',
  `school_name` varchar(255) NOT NULL DEFAULT '' COMMENT '学校名称',
  `school_id` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '关联标准学校 ID',
  `major_name` varchar(255) NOT NULL DEFAULT '' COMMENT '所学专业名称',
  `major_id` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '关联标准专业 ID',
  `start_date` date DEFAULT NULL COMMENT '学习开始日期，精确到月份',
  `end_date` date DEFAULT NULL COMMENT '学习结束日期，精确到月份',
  `edu_level` varchar(32) DEFAULT '' COMMENT '学历（参照个人学历的枚举）',
  `created` int(11) NOT NULL COMMENT '创建时间',
  `updated` int(11) NOT NULL COMMENT '修改时间',
  `summary` varchar(1024) DEFAULT NULL COMMENT '描述信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='简历详情（教育经历）';

LOCK TABLES `n2_member_education` WRITE;
/*!40000 ALTER TABLE `n2_member_education` DISABLE KEYS */;

INSERT INTO `n2_member_education` (`id`, `member_id`, `school_name`, `school_id`, `major_name`, `major_id`, `start_date`, `end_date`, `edu_level`, `created`, `updated`, `summary`)
VALUES
  (1,46,'清华大学',0,'计算机专业',0,'2009-09-01','2012-06-01','本科',0,1481030635,'学的很好');

/*!40000 ALTER TABLE `n2_member_education` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table n2_resume
# ------------------------------------------------------------

DROP TABLE IF EXISTS `n2_resume`;

CREATE TABLE `n2_resume` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '简历 ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '简历归属人 ID',
  `created` int(11) NOT NULL COMMENT '创建时间',
  `updator` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改人 ID',
  `updated` int(11) NOT NULL COMMENT '修改时间',
  `summary` text COMMENT '求职意向的补充说明',
  `post_name` varchar(64) DEFAULT NULL COMMENT '意向职位',
  `job_type` varchar(32) DEFAULT NULL COMMENT '工作性质（兼职、全职、实习）',
  `addr_city` varchar(32) DEFAULT NULL COMMENT '意向工作城市',
  `pay_range_from` int(11) DEFAULT NULL COMMENT '薪水下限（单位：千）',
  `pay_range_to` int(11) DEFAULT NULL COMMENT '薪水上限（单位：千）',
  `on_the_job` int(11) DEFAULT NULL COMMENT '是否在职（在职责工作结束日期为：至今）',
  `industry` varchar(256) DEFAULT NULL COMMENT '求职行业，可多个',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='简历表';

LOCK TABLES `n2_resume` WRITE;
/*!40000 ALTER TABLE `n2_resume` DISABLE KEYS */;

INSERT INTO `n2_resume` (`id`, `member_id`, `created`, `updator`, `updated`, `summary`, `post_name`, `job_type`, `addr_city`, `pay_range_from`, `pay_range_to`, `on_the_job`, `industry`)
VALUES
  (1,46,0,0,1481031237,'本文是音频处理的朋友icoolmedia（QQ：314138065）的投稿。对音频处理有兴趣的朋友可以通过下面的方式与他交流：作者：icoolmedia QQ：314138065 音视频算法讨论QQ群：374737122 原文公式较多，因此直接贴上图片','产品经理','兼职','杭州',12,32,1,'IT 电商');

/*!40000 ALTER TABLE `n2_resume` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table n2_resume_delivery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `n2_resume_delivery`;

CREATE TABLE `n2_resume_delivery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resume_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '简历 ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '投递人 ID',
  `delivery_time` int(11) NOT NULL COMMENT '投递时间',
  `delivery_company_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '投递到的公司 ID',
  `delivery_job_id` int(11) NOT NULL DEFAULT '0' COMMENT '投递岗位',
  `deliver_status` varchar(32) NOT NULL DEFAULT '0' COMMENT '投递状态，0-待投递，1-已投递',
  `receiver_status` varchar(32) NOT NULL DEFAULT '0' COMMENT '受理状态，0-待受理，1-已受理',
  `process_status` varchar(32) NOT NULL DEFAULT '0' COMMENT '处理状态，0-待处理，1-同意，2-拒绝，3-待定',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='简历投递记录';

LOCK TABLES `n2_resume_delivery` WRITE;
/*!40000 ALTER TABLE `n2_resume_delivery` DISABLE KEYS */;

INSERT INTO `n2_resume_delivery` (`id`, `resume_id`, `member_id`, `delivery_time`, `delivery_company_id`, `delivery_job_id`, `deliver_status`, `receiver_status`, `process_status`)
VALUES
  (2,1,46,1481450728,8,5,'已投递','已受理','待处理'),
  (3,1,46,1481451619,6,6,'已投递','已受理','待处理');

/*!40000 ALTER TABLE `n2_resume_delivery` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
