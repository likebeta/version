/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2013-07-01 14:51:56
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
INSERT INTO commonsvrds VALUES ('2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2013-07-01 09:58:48');

-- ----------------------------
-- Table structure for `gameinfo`
-- ----------------------------
DROP TABLE IF EXISTS `gameinfo`;
CREATE TABLE `gameinfo` (
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`type`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gameinfo
-- ----------------------------
INSERT INTO gameinfo VALUES ('1', 'ddz', '斗地主');
INSERT INTO gameinfo VALUES ('9', 'ld', '雷电');

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
  CONSTRAINT `versions_ibfk_1` FOREIGN KEY (`type`) REFERENCES `gameinfo` (`type`),
  CONSTRAINT `versions_ibfk_2` FOREIGN KEY (`commonsvrds_ver`) REFERENCES `commonsvrds` (`version`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of versions
-- ----------------------------
INSERT INTO versions VALUES ('1', '1', 'release1.0_9527', 'release1.0_9666', 'release1.0_1022', '1', '2013-06-29 18:37:41', 'æ–—åœ°ä¸»å‡çº§ï¼Œæ·»åŠ moenyé™åˆ¶');
INSERT INTO versions VALUES ('2', '9', '2', '2', '2', '2', '2013-07-01 09:58:21', '5555');
INSERT INTO versions VALUES ('3', '1', '3', '3', '3', '2', '2013-07-01 10:12:24', '333333333');
INSERT INTO versions VALUES ('4', '9', '3', '3', '3', '1', '2013-07-01 11:41:26', '4952132152861225');

-- ----------------------------
-- View structure for `gamevisioninfo`
-- ----------------------------
DROP VIEW IF EXISTS `gamevisioninfo`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gamevisioninfo` AS select `v`.`version` AS `version`,`g`.`type` AS `type`,`g`.`name` AS `name`,`g`.`description` AS `description`,`v`.`so` AS `so`,`v`.`gamesvrd` AS `gamesvrd`,`v`.`client` AS `client`,`v`.`commonsvrds_ver` AS `commonsvrds_ver`,`c`.`adminsvrd` AS `adminsvrd`,`c`.`dbsvrd` AS `dbsvrd`,`c`.`friendsvrd` AS `friendsvrd`,`c`.`logsvrd` AS `logsvrd`,`c`.`propertysvrd` AS `propertysvrd`,`c`.`proxysvrd` AS `proxysvrd`,`c`.`roommngsvrd` AS `roommngsvrd`,`c`.`shopsvrd` AS `shopsvrd`,`c`.`statsvrd` AS `statsvrd`,`c`.`websvrd` AS `websvrd`,`v`.`time` AS `time`,`v`.`comment` AS `comment` from ((`versions` `v` join `gameinfo` `g`) join `commonsvrds` `c`) where ((`v`.`type` = `g`.`type`) and (`v`.`commonsvrds_ver` = `c`.`version`));
