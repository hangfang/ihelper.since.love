/*
Navicat MySQL Data Transfer

Source Server         : aliyun
Source Server Version : 50542
Source Host           : 127.0.0.1:3306
Source Database       : ihelper

Target Server Type    : MYSQL
Target Server Version : 50542
File Encoding         : 65001

Date: 2016-04-17 11:35:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for app_dlt
-- ----------------------------
DROP TABLE IF EXISTS `app_dlt`;
CREATE TABLE `app_dlt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `a` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `b` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `c` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `d` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `e` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `f` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `g` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `sell` int(10) unsigned NOT NULL,
  `remain` int(10) unsigned NOT NULL,
  `first_add` varchar(255) NOT NULL DEFAULT '',
  `first_add_num` int(10) unsigned NOT NULL,
  `first` varchar(255) NOT NULL DEFAULT '',
  `first_num` int(10) unsigned NOT NULL,
  `second_add` varchar(255) NOT NULL DEFAULT '',
  `second_add_num` int(10) unsigned NOT NULL,
  `second` varchar(255) NOT NULL DEFAULT '',
  `second_num` int(10) unsigned NOT NULL,
  `third_add` varchar(255) NOT NULL DEFAULT '',
  `third_add_num` int(10) unsigned NOT NULL,
  `third` varchar(255) NOT NULL DEFAULT '',
  `third_num` int(10) unsigned NOT NULL,
  `forth_add` varchar(255) NOT NULL DEFAULT '',
  `forth_add_num` int(10) unsigned NOT NULL DEFAULT '0',
  `forth` varchar(255) NOT NULL DEFAULT '',
  `forth_num` int(10) unsigned NOT NULL,
  `fivth_add` varchar(255) NOT NULL DEFAULT '',
  `fivth_add_num` int(10) unsigned NOT NULL DEFAULT '0',
  `fivth` varchar(255) NOT NULL DEFAULT '',
  `fivth_num` int(10) unsigned NOT NULL,
  `sixth_add` varchar(255) NOT NULL DEFAULT '',
  `sixth_add_num` int(10) unsigned NOT NULL DEFAULT '0',
  `sixth` varchar(255) NOT NULL DEFAULT '',
  `sixth_num` int(10) unsigned NOT NULL,
  `expect` varchar(255) NOT NULL,
  `insert_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4594 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for app_fc3d
-- ----------------------------
DROP TABLE IF EXISTS `app_fc3d`;
CREATE TABLE `app_fc3d` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `a` tinyint(2) unsigned NOT NULL,
  `b` tinyint(2) unsigned NOT NULL,
  `c` tinyint(2) unsigned NOT NULL,
  `sell` int(10) unsigned NOT NULL,
  `remain` int(10) unsigned NOT NULL,
  `first` int(10) unsigned NOT NULL,
  `first_num` int(10) unsigned NOT NULL,
  `second` int(10) unsigned NOT NULL,
  `second_num` int(10) unsigned NOT NULL,
  `expect` varchar(255) NOT NULL,
  `insert_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6020 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for app_pl3
-- ----------------------------
DROP TABLE IF EXISTS `app_pl3`;
CREATE TABLE `app_pl3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `a` tinyint(2) unsigned NOT NULL,
  `b` tinyint(2) unsigned NOT NULL,
  `c` tinyint(2) unsigned NOT NULL,
  `sell` int(10) unsigned NOT NULL,
  `remain` int(10) unsigned NOT NULL,
  `first` int(10) unsigned NOT NULL,
  `first_num` int(10) unsigned NOT NULL,
  `second` int(10) unsigned NOT NULL,
  `second_num` int(10) unsigned NOT NULL,
  `expect` varchar(255) NOT NULL,
  `insert_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9975 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for app_pl5
-- ----------------------------
DROP TABLE IF EXISTS `app_pl5`;
CREATE TABLE `app_pl5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `a` tinyint(2) unsigned NOT NULL,
  `b` tinyint(2) unsigned NOT NULL,
  `c` tinyint(2) unsigned NOT NULL,
  `sell` int(10) unsigned NOT NULL,
  `remain` int(10) unsigned NOT NULL,
  `first` int(10) unsigned NOT NULL,
  `first_num` int(10) unsigned NOT NULL,
  `expect` varchar(255) NOT NULL,
  `insert_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10097 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for app_qxc
-- ----------------------------
DROP TABLE IF EXISTS `app_qxc`;
CREATE TABLE `app_qxc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `a` tinyint(2) unsigned NOT NULL,
  `b` tinyint(2) unsigned NOT NULL,
  `c` tinyint(2) unsigned NOT NULL,
  `d` tinyint(2) unsigned NOT NULL,
  `e` tinyint(2) unsigned NOT NULL,
  `f` tinyint(2) unsigned NOT NULL,
  `g` tinyint(2) unsigned NOT NULL,
  `sell` int(10) unsigned NOT NULL,
  `remain` int(10) unsigned NOT NULL,
  `first` varchar(255) NOT NULL DEFAULT '',
  `first_num` int(10) unsigned NOT NULL,
  `second` varchar(255) NOT NULL DEFAULT '',
  `second_num` int(10) unsigned NOT NULL,
  `third` varchar(255) NOT NULL DEFAULT '',
  `third_num` int(10) unsigned NOT NULL,
  `forth` varchar(255) NOT NULL DEFAULT '',
  `forth_num` int(10) unsigned NOT NULL,
  `fivth` varchar(255) NOT NULL DEFAULT '',
  `fivth_num` int(10) unsigned NOT NULL,
  `sixth` varchar(255) NOT NULL DEFAULT '',
  `sixth_num` int(10) unsigned NOT NULL,
  `expect` varchar(255) NOT NULL,
  `insert_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3770 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for app_ssq
-- ----------------------------
DROP TABLE IF EXISTS `app_ssq`;
CREATE TABLE `app_ssq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `a` tinyint(2) unsigned NOT NULL,
  `b` tinyint(2) unsigned NOT NULL,
  `c` tinyint(2) unsigned NOT NULL,
  `d` tinyint(2) unsigned NOT NULL,
  `e` tinyint(2) unsigned NOT NULL,
  `f` tinyint(2) unsigned NOT NULL,
  `g` tinyint(2) unsigned NOT NULL,
  `sell` int(10) unsigned NOT NULL,
  `remain` int(10) unsigned NOT NULL,
  `first` varchar(255) NOT NULL DEFAULT '',
  `first_num` int(10) unsigned NOT NULL,
  `second` varchar(255) NOT NULL DEFAULT '',
  `second_num` int(10) unsigned NOT NULL,
  `third` varchar(255) NOT NULL DEFAULT '',
  `third_num` int(10) unsigned NOT NULL,
  `forth` varchar(255) NOT NULL DEFAULT '',
  `forth_num` int(10) unsigned NOT NULL,
  `fivth` varchar(255) NOT NULL DEFAULT '',
  `fivth_num` int(10) unsigned NOT NULL,
  `sixth` varchar(255) NOT NULL DEFAULT '',
  `sixth_num` int(10) unsigned NOT NULL,
  `expect` varchar(255) NOT NULL,
  `insert_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1942 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wechat_receive_message
-- ----------------------------
DROP TABLE IF EXISTS `wechat_receive_message`;
CREATE TABLE `wechat_receive_message` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Content` text NOT NULL,
  `CreateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Description` varchar(255) NOT NULL DEFAULT '',
  `Event` varchar(255) NOT NULL DEFAULT '',
  `EventKey` varchar(255) NOT NULL DEFAULT '',
  `Format` varchar(255) NOT NULL DEFAULT '',
  `FromUserName` varchar(255) NOT NULL DEFAULT '',
  `Label` varchar(255) NOT NULL DEFAULT '',
  `Latitude` decimal(9,6) NOT NULL DEFAULT '0.000000',
  `Location_X` decimal(9,6) NOT NULL DEFAULT '0.000000',
  `Location_Y` decimal(9,6) NOT NULL DEFAULT '0.000000',
  `Longitude` decimal(9,6) NOT NULL DEFAULT '0.000000',
  `MediaId` bigint(20) unsigned NOT NULL DEFAULT '0',
  `MsgId` bigint(20) unsigned NOT NULL DEFAULT '0',
  `MsgType` varchar(255) NOT NULL DEFAULT '',
  `PicUrl` varchar(255) NOT NULL DEFAULT '',
  `Precision` decimal(9,6) NOT NULL DEFAULT '0.000000',
  `Recognition` varchar(255) NOT NULL DEFAULT '',
  `Scale` decimal(10,0) NOT NULL DEFAULT '0',
  `ThumbMediaId` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Ticket` varchar(255) NOT NULL DEFAULT '',
  `Title` varchar(255) NOT NULL DEFAULT '',
  `ToUserName` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `ToUserName` (`ToUserName`) USING BTREE,
  KEY `FromUserName` (`FromUserName`),
  KEY `MsgId` (`MsgId`),
  KEY `MsgType` (`MsgType`),
  KEY `CreateTime` (`CreateTime`),
  KEY `Format` (`Format`)
) ENGINE=MyISAM AUTO_INCREMENT=2581 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wechat_send_message
-- ----------------------------
DROP TABLE IF EXISTS `wechat_send_message`;
CREATE TABLE `wechat_send_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articles` text NOT NULL,
  `article_count` int(11) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` varchar(255) NOT NULL DEFAULT '',
  `fromuser` varchar(255) NOT NULL DEFAULT '',
  `hqmusicurl` varchar(255) NOT NULL DEFAULT '',
  `media_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `msgtype` varchar(255) NOT NULL DEFAULT '',
  `musicurl` varchar(255) NOT NULL DEFAULT '',
  `picurl` varchar(255) NOT NULL DEFAULT '',
  `thumb_media_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `touser` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `touser` (`touser`) USING BTREE,
  KEY `msgtype` (`msgtype`),
  KEY `createtime` (`createtime`)
) ENGINE=MyISAM AUTO_INCREMENT=1212 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wechat_token
-- ----------------------------
DROP TABLE IF EXISTS `wechat_token`;
CREATE TABLE `wechat_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jsapi_ticket` varchar(255) NOT NULL DEFAULT '',
  `token` varchar(255) NOT NULL DEFAULT '',
  `insert_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wechat_user
-- ----------------------------
DROP TABLE IF EXISTS `wechat_user`;
CREATE TABLE `wechat_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insert_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `openid` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
