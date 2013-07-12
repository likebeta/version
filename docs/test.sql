/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2013-07-12 22:04:44
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `basesvrds`
-- ----------------------------
DROP TABLE IF EXISTS `basesvrds`;
CREATE TABLE `basesvrds` (
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

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
-- Table structure for `versions`
-- ----------------------------
DROP TABLE IF EXISTS `versions`;
CREATE TABLE `versions` (
  `version` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `so` varchar(255) NOT NULL,
  `gamesvrd` varchar(255) NOT NULL,
  `client` varchar(255) NOT NULL,
  `basesvrds_ver` int(11) unsigned NOT NULL,
  `time` datetime NOT NULL,
  `comment` text,
  PRIMARY KEY (`version`),
  KEY `type` (`type`),
  KEY `basesvrds_ver` (`basesvrds_ver`),
  CONSTRAINT `versions_ibfk_1` FOREIGN KEY (`type`) REFERENCES `gameinfo` (`type`),
  CONSTRAINT `versions_ibfk_2` FOREIGN KEY (`basesvrds_ver`) REFERENCES `basesvrds` (`version`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- View structure for `gamevisioninfo`
-- ----------------------------
DROP VIEW IF EXISTS `gamevisioninfo`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gamevisioninfo` AS select `v`.`version` AS `version`,`g`.`type` AS `type`,`g`.`name` AS `name`,`g`.`description` AS `description`,`v`.`so` AS `so`,`v`.`gamesvrd` AS `gamesvrd`,`v`.`client` AS `client`,`v`.`basesvrds_ver` AS `basesvrds_ver`,`c`.`adminsvrd` AS `adminsvrd`,`c`.`dbsvrd` AS `dbsvrd`,`c`.`friendsvrd` AS `friendsvrd`,`c`.`logsvrd` AS `logsvrd`,`c`.`propertysvrd` AS `propertysvrd`,`c`.`proxysvrd` AS `proxysvrd`,`c`.`roommngsvrd` AS `roommngsvrd`,`c`.`shopsvrd` AS `shopsvrd`,`c`.`statsvrd` AS `statsvrd`,`c`.`websvrd` AS `websvrd`,`v`.`time` AS `time`,`v`.`comment` AS `comment` from ((`versions` `v` join `gameinfo` `g`) join `basesvrds` `c`) where ((`v`.`type` = `g`.`type`) and (`v`.`basesvrds_ver` = `c`.`version`));
