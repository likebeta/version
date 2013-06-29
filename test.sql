/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2013-06-29 20:17:20
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `commonsvrds`
-- ----------------------------
DROP TABLE IF EXISTS `commonsvrds`;
CREATE TABLE `commonsvrds` (
  `version` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `adminsvrd` varchar(255) NOT NULL,
  `dbsvrd` varchar(255) NOT NULL,
  `friendsvrd` varchar(255) NOT NULL,
  `logsvrd` varchar(255) NOT NULL,
  `propertysvrd` varchar(255) NOT NULL,
  `proxysvrd` varchar(255) NOT NULL,
  `roommngsvrd` varchar(255) NOT NULL,
  `shopsvrd` varchar(255) NOT NULL,
  `statsvrd` varchar(255) NOT NULL,
  `websvrd` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of commonsvrds
-- ----------------------------
INSERT INTO commonsvrds VALUES ('1', 'adminsvrd1.0', 'dbsvrd1.0', 'friendsvrd1.0', 'logsvrd1.0', 'propretysvrd1.0', 'proxysvrd1.0', 'roommngsvrd1.0', 'shopsvrd1.0', 'statsvrd1.0', 'websvrd1.0', '2013-06-29 18:32:17');

-- ----------------------------
-- Table structure for `gametype`
-- ----------------------------
DROP TABLE IF EXISTS `gametype`;
CREATE TABLE `gametype` (
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`type`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gametype
-- ----------------------------
INSERT INTO gametype VALUES ('1', 'ddz', '斗地主');
INSERT INTO gametype VALUES ('9', 'ld', '雷电');

-- ----------------------------
-- Table structure for `versions`
-- ----------------------------
DROP TABLE IF EXISTS `versions`;
CREATE TABLE `versions` (
  `version` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `so` varchar(255) NOT NULL,
  `gamesvrd` varchar(255) NOT NULL,
  `client` varchar(255) NOT NULL,
  `commonsvrds_ver` int(11) unsigned NOT NULL,
  `time` datetime NOT NULL,
  `comment` text,
  PRIMARY KEY (`version`),
  KEY `type` (`type`),
  KEY `commonsvrds_ver` (`commonsvrds_ver`),
  CONSTRAINT `versions_ibfk_1` FOREIGN KEY (`type`) REFERENCES `gametype` (`type`),
  CONSTRAINT `versions_ibfk_2` FOREIGN KEY (`commonsvrds_ver`) REFERENCES `commonsvrds` (`version`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of versions
-- ----------------------------
INSERT INTO versions VALUES ('1', '1', 'release1.0_9527', 'release1.0_9666', 'release1.0_1022', '1', '2013-06-29 18:37:41', 'æ–—åœ°ä¸»å‡çº§ï¼Œæ·»åŠ moenyé™åˆ¶');
