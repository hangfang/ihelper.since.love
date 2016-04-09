/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50626
Source Host           : localhost:3306
Source Database       : ihelper

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2016-04-09 13:05:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wechat_receive_message
-- ----------------------------
CREATE TABLE `wechat_receive_message` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Content` varchar(255) NOT NULL DEFAULT '',
  `CreateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Description` varchar(255) NOT NULL DEFAULT '',
  `Event` varchar(255) NOT NULL DEFAULT '',
  `EventKey` varchar(255) NOT NULL DEFAULT '',
  `Format` varchar(255) NOT NULL DEFAULT '',
  `FromUserName` varchar(255) NOT NULL DEFAULT '',
  `Label` varchar(255) NOT NULL DEFAULT '',
  `Location_X` decimal(9,6) NOT NULL DEFAULT '0.000000',
  `Location_Y` decimal(9,6) NOT NULL DEFAULT '0.000000',
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
) ENGINE=MyISAM AUTO_INCREMENT=1469 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for wechat_send_message
-- ----------------------------
DROP TABLE IF EXISTS `wechat_send_message`;
CREATE TABLE `wechat_send_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articles` text NOT NULL,
  `article_count` int(11) NOT NULL DEFAULT '0',
  `content` varchar(255) NOT NULL DEFAULT '',
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
) ENGINE=MyISAM AUTO_INCREMENT=749 DEFAULT CHARSET=utf8;

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

CREATE TABLE `wechat_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insert_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `openid` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

