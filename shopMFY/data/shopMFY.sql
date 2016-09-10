DROP DATABASE `shopMFY`;
CREATE DATABASE IF NOT EXISTS `shopMFY`;
USE `shopMFY`;
-- 管理员表 --
DROP TABLE IF EXISTS `MFY_admin`;

CREATE TABLE `MFY_admin` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

LOCK TABLES `MFY_admin` WRITE;
INSERT INTO `MFY_admin` VALUES (1,'king','b2086154f101464aab3328ba7e060deb','419626329@qq.com'),(2,'admin','21232f297a57a5a743894a0e4a801fc3','419626329@qq.com');
UNLOCK TABLES;

-- 相册表 --
DROP TABLE IF EXISTS `MFY_album`;
CREATE TABLE`MFY_album`(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned NOT NULL,
  `albumPath` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;


-- 分类表  --
DROP TABLE IF EXISTS `MFY_cate`;
CREATE TABLE `MFY_cate`(
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cName` (`cName`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;



-- 商品表 --
DROP TABLE IF EXISTS `MFY_pro`;
CREATE TABLE `MFY_pro`(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pName` varchar(255) NOT NULL,
  `pSn` varchar(50) NOT NULL,
  `pNum` int(10) unsigned DEFAULT '1',
  `mPrice` decimal(10,2) NOT NULL,
  `iPrice` decimal(10,2) NOT NULL,
  `pDesc` text,
  `pubTime` int(10) unsigned NOT NULL,
  `isShow` tinyint(1) DEFAULT '1',
  `isHot` tinyint(1) DEFAULT '0',
  `cId` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pName` (`pName`),
  UNIQUE KEY `pName_2` (`pName`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;


-- 用户表 --
DROP TABLE IF EXISTS `MFY_user`;
CREATE TABLE `MFY_user`(
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(32) NOT NULL,
  `sex` enum('男','女','保密') NOT NULL DEFAULT '保密',
  `email` varchar(50) NOT NULL,
  `face` varchar(50) NOT NULL,
  `regTime` int(10) unsigned NOT NULL,
  `activeFlag` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

