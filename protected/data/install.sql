-- MySQL dump 10.13  Distrib 5.6.21, for osx10.10 (x86_64)
--
-- Host: localhost    Database: edu_trunk
-- ------------------------------------------------------
-- Server version	5.6.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `AuthAssignment`
--

DROP TABLE IF EXISTS `AuthAssignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `AuthItem`
--

DROP TABLE IF EXISTS `AuthItem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `AuthItemChild`
--

DROP TABLE IF EXISTS `AuthItemChild`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Rights`
--

DROP TABLE IF EXISTS `Rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `YiiSession`
--

DROP TABLE IF EXISTS `YiiSession`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `YiiSession` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  `userId` int(11) NOT NULL COMMENT '用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_announcement`
--

DROP TABLE IF EXISTS `ew_announcement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_announcement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `courseId` int(11) NOT NULL,
  `content` text NOT NULL,
  `addTime` int(11) NOT NULL,
  `upTime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_answer`
--

DROP TABLE IF EXISTS `ew_answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `questionId` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `addTime` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) NOT NULL DEFAULT '0',
  `isCorrect` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_area`
--

DROP TABLE IF EXISTS `ew_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL,
  `name` varchar(20) NOT NULL,
  `cityCode` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_article`
--

DROP TABLE IF EXISTS `ew_article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `entityId` int(11) NOT NULL DEFAULT '0' COMMENT 'EntityId',
  `categoryId` int(11) NOT NULL DEFAULT '0' COMMENT '分类表Id',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `face` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'http://placehold.it/210x140' COMMENT '封面',
  `content` text COLLATE utf8_unicode_ci COMMENT '内容',
  `addTime` int(10) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upTime` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `keyWord` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '关键字',
  `commentNum` int(11) NOT NULL DEFAULT '0' COMMENT '评论数',
  `viewNum` int(11) NOT NULL DEFAULT '0' COMMENT '阅读数',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `isTop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_bottom_text`
--

DROP TABLE IF EXISTS `ew_bottom_text`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_bottom_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='静态页面';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_carousel`
--

DROP TABLE IF EXISTS `ew_carousel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_carousel` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '笔记id',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `path` char(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `url` varchar(1024) NOT NULL DEFAULT '' COMMENT '对应链接',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `courseId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='首页轮播图片';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_category`
--

DROP TABLE IF EXISTS `ew_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '笔记id',
  `name` char(64) NOT NULL DEFAULT '' COMMENT '类型',
  `parentId` int(11) NOT NULL DEFAULT '0' COMMENT '父级分类',
  `type` char(64) NOT NULL DEFAULT '' COMMENT '类型,book,course等',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `userId` int(11) NOT NULL DEFAULT '0' COMMENT '创建者',
  `description` text,
  `addTime` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_chapter`
--

DROP TABLE IF EXISTS `ew_chapter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `courseId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT '0',
  `number` int(11) NOT NULL DEFAULT '0',
  `lessonNum` int(11) NOT NULL DEFAULT '0',
  `title` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `addTime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_city`
--

DROP TABLE IF EXISTS `ew_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL,
  `name` varchar(20) NOT NULL,
  `provinceCode` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_cms_people`
--

DROP TABLE IF EXISTS `ew_cms_people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_cms_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL COMMENT '用户ID',
  `categoryId` int(11) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `face` char(255) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL COMMENT '教师姓名',
  `description` varchar(255) DEFAULT NULL COMMENT '教师简介',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='教师表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_collect`
--

DROP TABLE IF EXISTS `ew_collect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主id',
  `userId` int(11) NOT NULL DEFAULT '0' COMMENT '关注者id',
  `collectableEntityId` int(11) NOT NULL DEFAULT '0' COMMENT '被收藏',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '关注时间',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='关注表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_comment`
--

DROP TABLE IF EXISTS `ew_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `title` char(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `addTime` int(11) DEFAULT '0' COMMENT '发表时间',
  `ew_rate` int(11) NOT NULL DEFAULT '0' COMMENT '评分',
  `userId` int(11) NOT NULL COMMENT '发表者id',
  `commentableEntityId` int(11) NOT NULL DEFAULT '0' COMMENT '评论对象id',
  `entityId` int(11) NOT NULL DEFAULT '0' COMMENT 'Entity对象Id',
  `referId` int(11) NOT NULL DEFAULT '0' COMMENT '引用回复',
  `voteUpNum` int(11) NOT NULL DEFAULT '0',
  `voteDownNum` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleteTime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='评论';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_course`
--

DROP TABLE IF EXISTS `ew_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '课程id',
  `name` char(64) NOT NULL COMMENT '课程名称',
  `userId` int(11) NOT NULL COMMENT '课程创建人id',
  `memberNum` int(11) NOT NULL DEFAULT '0' COMMENT '修课人数',
  `viewNum` int(11) NOT NULL DEFAULT '0' COMMENT '点击量',
  `fee` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '费用',
  `entityId` int(11) NOT NULL DEFAULT '0',
  `categoryId` int(11) NOT NULL DEFAULT '0' COMMENT '课程分类',
  `face` char(255) NOT NULL DEFAULT '' COMMENT '课程头像存放位置',
  `introduction` text COMMENT '课程简介',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态，ok,applied,created',
  `rateScore` decimal(3,1) NOT NULL DEFAULT '0.0' COMMENT '平均得分',
  `rateNum` int(11) NOT NULL DEFAULT '0' COMMENT '评分人次',
  `targetStudent` varchar(1024) NOT NULL DEFAULT '' COMMENT '目标学员',
  `subTitle` char(255) NOT NULL DEFAULT '' COMMENT '副标题',
  `isTop` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleteTime` int(11) NOT NULL DEFAULT '0',
  `studentNum` int(11) NOT NULL DEFAULT '0',
  `validTime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='课程表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_course_log`
--

DROP TABLE IF EXISTS `ew_course_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_course_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `courseId` int(11) NOT NULL,
  `logId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_course_member`
--

DROP TABLE IF EXISTS `ew_course_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_course_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `orderId` int(11) NOT NULL DEFAULT '0',
  `startTime` int(11) NOT NULL,
  `endTime` int(11) NOT NULL DEFAULT '0',
  `courseId` int(11) NOT NULL DEFAULT '0',
  `userId` int(11) NOT NULL DEFAULT '0',
  `roles` char(64) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `commentNum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `courseId` (`courseId`,`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='选课成员';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_course_post`
--

DROP TABLE IF EXISTS `ew_course_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_course_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '帖子id',
  `courseId` int(11) NOT NULL,
  `lessonId` int(11) NOT NULL DEFAULT '0',
  `title` varchar(128) NOT NULL COMMENT '帖子标题',
  `content` text NOT NULL COMMENT '帖子内容',
  `upTime` int(11) DEFAULT NULL COMMENT '更新时间',
  `addTime` int(11) DEFAULT NULL COMMENT '添加时间',
  `userId` int(11) NOT NULL COMMENT '发表者id',
  `commentNum` int(11) NOT NULL DEFAULT '0' COMMENT '回帖总数',
  `viewNum` int(11) NOT NULL DEFAULT '0' COMMENT '浏览总数',
  `voteNum` int(11) NOT NULL DEFAULT '0' COMMENT '投票总数',
  `isTop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `isDigest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否精华帖',
  `voteUpNum` int(11) NOT NULL DEFAULT '0' COMMENT '赞',
  `voteDownNum` int(11) NOT NULL DEFAULT '0' COMMENT '赞',
  `commentableEntityId` int(11) NOT NULL DEFAULT '0' COMMENT '评论对象id',
  `entityId` int(11) NOT NULL DEFAULT '0' COMMENT 'Entity对象Id',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleteTime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COMMENT='讨论区帖子';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_course_quiz_report`
--

DROP TABLE IF EXISTS `ew_course_quiz_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_course_quiz_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `courseId` int(11) NOT NULL,
  `quizIds` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `avgScore` decimal(5,2) DEFAULT NULL,
  `totalScore` decimal(5,2) DEFAULT NULL,
  `quizNum` int(11) NOT NULL DEFAULT '0',
  `correctNum` int(11) NOT NULL DEFAULT '0',
  `partialCorrectNum` int(11) NOT NULL DEFAULT '0',
  `wrongNum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_entity`
--

DROP TABLE IF EXISTS `ew_entity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `type` char(32) NOT NULL DEFAULT '' COMMENT 'user,group，post,comment',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COMMENT='可挂载对象';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_event`
--

DROP TABLE IF EXISTS `ew_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keyWork` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `addTime` int(11) NOT NULL,
  `upTime` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `viewNum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_file`
--

DROP TABLE IF EXISTS `ew_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文档id',
  `userId` int(11) NOT NULL COMMENT '文件创建人id',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` char(32) NOT NULL DEFAULT '' COMMENT '状态,unpublished,ok',
  `path` char(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `type` char(64) NOT NULL DEFAULT '' COMMENT '文件类型',
  `name` char(255) NOT NULL DEFAULT '' COMMENT '文件名字',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '文件大小',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文件';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_follow`
--

DROP TABLE IF EXISTS `ew_follow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主id',
  `userId` int(11) NOT NULL DEFAULT '0' COMMENT '关注者id',
  `followableEntityId` int(11) NOT NULL DEFAULT '0' COMMENT '被关注者',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '关注时间',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='关注表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_friend_link`
--

DROP TABLE IF EXISTS `ew_friend_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_friend_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主id',
  `title` char(128) NOT NULL DEFAULT '' COMMENT '文字',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `logo` char(255) NOT NULL DEFAULT '' COMMENT 'logo图片',
  `weight` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='友情链接';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_group`
--

DROP TABLE IF EXISTS `ew_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` char(64) NOT NULL COMMENT '名称',
  `face` char(255) NOT NULL DEFAULT '' COMMENT '头像存放位置',
  `userId` int(11) NOT NULL COMMENT '小组创建人id',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `introduction` text COMMENT '课程简介',
  `status` char(32) NOT NULL DEFAULT '' COMMENT '状态，ok,applied,created',
  `memberNum` int(11) NOT NULL DEFAULT '0' COMMENT '人数',
  `viewNum` int(11) NOT NULL DEFAULT '0' COMMENT '点击量',
  `postableEntityId` int(11) DEFAULT NULL COMMENT '发帖对象id',
  `joinType` char(32) NOT NULL DEFAULT 'free' COMMENT '加入方式：apply,free',
  `entityId` int(11) NOT NULL DEFAULT '0' COMMENT 'Entity对象Id',
  `isTop` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `categoryId` int(11) NOT NULL DEFAULT '0' COMMENT '分类',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleteTime` int(11) NOT NULL DEFAULT '0',
  `leaderTitle` char(32) NOT NULL DEFAULT '组长',
  `memberTitle` char(32) NOT NULL DEFAULT '成员',
  `adminTitle` char(32) NOT NULL DEFAULT '管理员',
  PRIMARY KEY (`id`),
  UNIQUE KEY `postableEntityId` (`postableEntityId`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='小组表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_group_course`
--

DROP TABLE IF EXISTS `ew_group_course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_group_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `groupId` int(11) NOT NULL DEFAULT '0' COMMENT '小组id',
  `courseId` int(11) NOT NULL DEFAULT '0' COMMENT '课程id',
  `userId` int(11) NOT NULL DEFAULT '0' COMMENT '收录者id',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `groupId` (`groupId`),
  KEY `courseId` (`courseId`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小组收藏课程';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_group_member`
--

DROP TABLE IF EXISTS `ew_group_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_group_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `userId` int(11) NOT NULL COMMENT '发表者id',
  `memberableEntityId` int(11) NOT NULL DEFAULT '0' COMMENT '拥有成员的entity',
  `addTime` int(11) DEFAULT '0' COMMENT '加入时间',
  `upTime` int(11) DEFAULT '0' COMMENT '更新时间',
  `roles` char(64) NOT NULL DEFAULT '' COMMENT '角色组',
  `groupId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='用户从属关系表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_lesson`
--

DROP TABLE IF EXISTS `ew_lesson`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_lesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '课时id',
  `title` char(255) NOT NULL DEFAULT '' COMMENT '标题',
  `courseId` int(11) NOT NULL COMMENT '所属课程id',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '重量，用于课时排序，weight小的在前',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upTime` int(11) NOT NULL DEFAULT '0' COMMENT '最新修改时间',
  `mediaId` int(11) NOT NULL DEFAULT '0',
  `mediaSource` char(32) NOT NULL DEFAULT '' COMMENT '课时来源',
  `mediaUri` char(255) NOT NULL DEFAULT '',
  `mediaName` char(255) NOT NULL DEFAULT '',
  `viewNum` int(11) NOT NULL DEFAULT '0' COMMENT '点击',
  `introduction` text COMMENT '简介',
  `entityId` int(11) NOT NULL DEFAULT '0',
  `userId` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `mediaType` char(32) NOT NULL DEFAULT 'video',
  `status` int(11) NOT NULL DEFAULT '0',
  `isFree` tinyint(1) NOT NULL DEFAULT '0',
  `number` int(11) NOT NULL DEFAULT '0',
  `chapterId` int(11) NOT NULL DEFAULT '0',
  `duration` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `courseId` (`courseId`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='课时表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_lesson_doc`
--

DROP TABLE IF EXISTS `ew_lesson_doc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_lesson_doc` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文档id',
  `lessonId` int(11) NOT NULL DEFAULT '0' COMMENT '课时id',
  `fileId` int(11) NOT NULL DEFAULT '0' COMMENT '文件id，reference(upload_file)',
  `description` text COMMENT '文件描述',
  `downloadNum` int(11) NOT NULL DEFAULT '0' COMMENT '下载次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课时文档资料';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_lesson_learn`
--

DROP TABLE IF EXISTS `ew_lesson_learn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_lesson_learn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lessonId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `startTime` int(11) NOT NULL DEFAULT '0',
  `finishTime` int(11) NOT NULL DEFAULT '0',
  `status` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_log`
--

DROP TABLE IF EXISTS `ew_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(128) DEFAULT NULL,
  `category` varchar(128) DEFAULT NULL,
  `logtime` int(11) unsigned DEFAULT NULL,
  `message` text,
  `userId` int(11) NOT NULL,
  `ip` varchar(128) NOT NULL COMMENT '写log时用户的ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_mail_log`
--

DROP TABLE IF EXISTS `ew_mail_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_mail_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `email` tinyint(4) NOT NULL DEFAULT '0' COMMENT '邮箱地址',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_media`
--

DROP TABLE IF EXISTS `ew_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '课时id',
  `title` char(255) NOT NULL DEFAULT '' COMMENT '标题',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接',
  `userId` int(11) NOT NULL COMMENT '用户id',
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '重量，用于课时排序，weight小的在前',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upTime` int(11) NOT NULL DEFAULT '0' COMMENT '最新修改时间',
  `introduction` text COMMENT '视频介绍',
  `type` char(32) NOT NULL DEFAULT 'link' COMMENT '课时内容类型',
  `viewNum` int(11) NOT NULL DEFAULT '0' COMMENT '课时点击次数',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课时表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_media_link`
--

DROP TABLE IF EXISTS `ew_media_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_media_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source` char(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  `title` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_message`
--

DROP TABLE IF EXISTS `ew_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '消息id',
  `fromUserId` int(11) NOT NULL COMMENT '发送者id',
  `toUserId` int(11) NOT NULL COMMENT '接收者id',
  `content` text NOT NULL COMMENT '内容',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  `isChecked` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否已读，0：未读，1已读',
  `isMailed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fromUserId` (`fromUserId`),
  KEY `toUserId` (`toUserId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='私信表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_nav`
--

DROP TABLE IF EXISTS `ew_nav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` char(32) NOT NULL DEFAULT '',
  `activeRule` char(255) NOT NULL DEFAULT '',
  `weight` int(11) NOT NULL DEFAULT '0',
  `url` char(255) NOT NULL DEFAULT '',
  `location` char(32) NOT NULL DEFAULT 'top',
  `displayRule` varchar(45) DEFAULT 'return true;',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_note`
--

DROP TABLE IF EXISTS `ew_note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '笔记id',
  `userId` int(11) NOT NULL COMMENT '用户id',
  `noteableEntityId` int(11) NOT NULL DEFAULT '0',
  `accessControl` char(32) NOT NULL DEFAULT 'private',
  `title` char(255) DEFAULT '' COMMENT '标题',
  `content` text COMMENT '笔记内容',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `upTime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `entityId` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='笔记表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_notice`
--

DROP TABLE IF EXISTS `ew_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '通知id',
  `userId` int(11) NOT NULL COMMENT '用户id',
  `data` varchar(1024) DEFAULT '' COMMENT '数据',
  `type` char(255) NOT NULL DEFAULT '' COMMENT '通知类型',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `isChecked` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读，1已读，0未读',
  `isMailed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='提醒，通知';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_order`
--

DROP TABLE IF EXISTS `ew_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `status` enum('created','paid','cancelled') NOT NULL,
  `subject` char(255) NOT NULL,
  `produceEntityId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `meansOfPayment` enum('none','alipay','tenpay','aliGuaran') DEFAULT NULL,
  `price` float NOT NULL DEFAULT '0',
  `addTime` int(11) NOT NULL DEFAULT '0',
  `paidTime` int(11) NOT NULL DEFAULT '0',
  `tradeNo` char(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_order_log`
--

DROP TABLE IF EXISTS `ew_order_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_order_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `orderId` int(11) NOT NULL,
  `note` text NOT NULL,
  `addTime` int(11) NOT NULL,
  `userId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_page`
--

DROP TABLE IF EXISTS `ew_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `userId` int(11) NOT NULL COMMENT '创建人id',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `title` char(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL,
  `weight` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `published` tinyint(10) NOT NULL DEFAULT '0',
  `key` char(255) NOT NULL DEFAULT '',
  `categoryId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='静态页面';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_post`
--

DROP TABLE IF EXISTS `ew_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '帖子id',
  `title` varchar(128) NOT NULL COMMENT '帖子标题',
  `content` text NOT NULL COMMENT '帖子内容',
  `upTime` int(11) DEFAULT NULL COMMENT '更新时间',
  `addTime` int(11) DEFAULT NULL COMMENT '添加时间',
  `userId` int(11) NOT NULL COMMENT '发表者id',
  `groupId` int(11) NOT NULL,
  `commentNum` int(11) NOT NULL DEFAULT '0' COMMENT '回帖总数',
  `viewNum` int(11) NOT NULL DEFAULT '0' COMMENT '浏览总数',
  `voteNum` int(11) NOT NULL DEFAULT '0' COMMENT '投票总数',
  `isTop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `isDigest` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否精华帖',
  `voteUpNum` int(11) NOT NULL DEFAULT '0' COMMENT '赞',
  `voteDownNum` int(11) NOT NULL DEFAULT '0' COMMENT '赞',
  `commentableEntityId` int(11) NOT NULL DEFAULT '0' COMMENT '评论对象id',
  `postableEntityId` int(11) NOT NULL DEFAULT '0',
  `entityId` int(11) NOT NULL DEFAULT '0' COMMENT 'Entity对象Id',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleteTime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='讨论区帖子';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_province`
--

DROP TABLE IF EXISTS `ew_province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_question`
--

DROP TABLE IF EXISTS `ew_question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stem` text COLLATE utf8_unicode_ci,
  `quizId` int(11) NOT NULL DEFAULT '0',
  `type` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'multiple-choice',
  `score` decimal(7,1) NOT NULL DEFAULT '1.0' COMMENT '得分',
  `solution` text COLLATE utf8_unicode_ci,
  `weight` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_question_choice`
--

DROP TABLE IF EXISTS `ew_question_choice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_question_choice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) NOT NULL,
  `isCorrect` tinyint(1) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='选项';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_question_report`
--

DROP TABLE IF EXISTS `ew_question_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_question_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) NOT NULL,
  `memberNum` int(11) NOT NULL DEFAULT '0',
  `partialCorrectRate` decimal(5,4) DEFAULT '0.0000',
  `wrongRate` decimal(5,4) DEFAULT '0.0000',
  `correctRate` decimal(5,4) DEFAULT '0.0000',
  `aNum` int(11) NOT NULL DEFAULT '0',
  `bNum` int(11) NOT NULL DEFAULT '0',
  `cNum` int(11) NOT NULL DEFAULT '0',
  `dNum` int(11) NOT NULL DEFAULT '0',
  `eNum` int(11) NOT NULL DEFAULT '0',
  `fNum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_question_response`
--

DROP TABLE IF EXISTS `ew_question_response`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_question_response` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `questionId` int(11) NOT NULL,
  `content` text,
  `addTime` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `score` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '得分',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_quiz`
--

DROP TABLE IF EXISTS `ew_quiz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci,
  `reportNum` int(11) NOT NULL DEFAULT '0',
  `questionNum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_quiz_report`
--

DROP TABLE IF EXISTS `ew_quiz_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_quiz_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quizId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `score` decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '得分',
  `correctNum` int(11) NOT NULL DEFAULT '0',
  `wrongNum` int(11) NOT NULL DEFAULT '0',
  `partialCorrectNum` int(11) NOT NULL DEFAULT '0',
  `teacherRemark` text COLLATE utf8_unicode_ci,
  `remarkTime` int(11) NOT NULL DEFAULT '0',
  `addTime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_rate`
--

DROP TABLE IF EXISTS `ew_rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `userId` int(11) NOT NULL DEFAULT '0' COMMENT '关注者id',
  `title` char(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `addTime` int(11) DEFAULT '0' COMMENT '发表时间',
  `upTime` int(11) DEFAULT '0' COMMENT '修改时间',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '评分',
  `rateableEntityId` int(11) NOT NULL DEFAULT '0' COMMENT '被评价者',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COMMENT='评价表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_system_setting`
--

DROP TABLE IF EXISTS `ew_system_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_system_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` char(64) NOT NULL COMMENT '名称',
  `value` text NOT NULL COMMENT '值',
  `description` text COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='系统设置值表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_upgrade_info`
--

DROP TABLE IF EXISTS `ew_upgrade_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_upgrade_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `versionId` int(11) NOT NULL COMMENT '记录服务器上升级包的id',
  `version` varchar(32) NOT NULL COMMENT '版本号',
  `name` varchar(256) NOT NULL COMMENT '包名称',
  `description` text COMMENT '包描述',
  `addTime` int(11) NOT NULL COMMENT '包添加时间',
  `status` varchar(32) NOT NULL DEFAULT 'not installed' COMMENT '包状态：not installed, installed',
  PRIMARY KEY (`id`),
  UNIQUE KEY `versionId` (`versionId`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='用来记录网站升级包的信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_upload_file`
--

DROP TABLE IF EXISTS `ew_upload_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_upload_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文档id',
  `userId` int(11) NOT NULL COMMENT '文件创建人id',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` char(32) NOT NULL DEFAULT '' COMMENT '状态,unpublished,ok',
  `path` char(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `mime` char(64) NOT NULL DEFAULT '' COMMENT '文件类型',
  `type` char(64) NOT NULL DEFAULT '' COMMENT '文件类型',
  `name` char(255) NOT NULL DEFAULT '' COMMENT '文件名字',
  `size` int(11) NOT NULL DEFAULT '0' COMMENT '文件大小',
  `storage` char(32) NOT NULL DEFAULT 'local',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文件';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_user`
--

DROP TABLE IF EXISTS `ew_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `email` char(64) NOT NULL COMMENT '用户email',
  `password` char(32) NOT NULL COMMENT '密码密文',
  `salt` char(32) NOT NULL COMMENT '与明文密码一起生成passwd',
  `resetPassword` char(64) NOT NULL DEFAULT '' COMMENT '重设密码用',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleteTime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_user_info`
--

DROP TABLE IF EXISTS `ew_user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_user_info` (
  `id` int(11) NOT NULL,
  `email` char(64) NOT NULL COMMENT '用户email',
  `name` char(64) NOT NULL COMMENT '用户名',
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否系统管理员',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '加入时间',
  `upTime` int(11) NOT NULL DEFAULT '0' COMMENT '上次登录时间',
  `face` char(255) NOT NULL DEFAULT '' COMMENT '个人头像',
  `status` char(32) NOT NULL DEFAULT '' COMMENT '用户状态，creted，verifying,ok',
  `introduction` text COMMENT '详细介绍',
  `verifyCode` char(32) NOT NULL DEFAULT '' COMMENT '邮箱验证码',
  `fanNum` int(11) NOT NULL DEFAULT '0' COMMENT '粉丝数',
  `answerNum` int(11) NOT NULL DEFAULT '0' COMMENT '回答数',
  `answerVoteupNum` int(11) NOT NULL DEFAULT '0' COMMENT '赞成数',
  `sex` char(8) NOT NULL DEFAULT '' COMMENT '性别',
  `entityId` int(11) NOT NULL DEFAULT '0' COMMENT 'Entity对象Id',
  `isTeacher` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否老师',
  `teacherIntroduction` varchar(2048) NOT NULL DEFAULT '',
  `bio` char(255) NOT NULL DEFAULT '' COMMENT '一句话自我介绍',
  `rennId` char(64) NOT NULL DEFAULT '',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleteTime` int(11) NOT NULL DEFAULT '0',
  `receiveMailNotify` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ew_vote`
--

DROP TABLE IF EXISTS `ew_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ew_vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `value` tinyint(4) NOT NULL DEFAULT '0' COMMENT '选票值，1为顶，0为踩',
  `userId` int(11) NOT NULL DEFAULT '0' COMMENT '评价者id',
  `addTime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `voteableEntityId` int(11) NOT NULL DEFAULT '0' COMMENT '评论对象id',
  `upTime` int(11) NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='记录一次对回答的投票评价';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_migration`
--

DROP TABLE IF EXISTS `tbl_migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_migration` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-31  9:32:29
