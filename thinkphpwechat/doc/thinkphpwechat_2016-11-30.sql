# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: thinkphpwechat.houdunren.com (MySQL 5.5.48)
# Database: thinkphpwechat
# Generation Time: 2016-11-29 17:04:34 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table hd_base_system
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hd_base_system`;

CREATE TABLE `hd_base_system` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `welcome` varchar(200) DEFAULT NULL,
  `default` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hd_base_system` WRITE;
/*!40000 ALTER TABLE `hd_base_system` DISABLE KEYS */;

INSERT INTO `hd_base_system` (`id`, `welcome`, `default`)
VALUES
	(1,'欢迎你关注后盾人','请联系古老师 13910959565');

/*!40000 ALTER TABLE `hd_base_system` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hd_button_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hd_button_data`;

CREATE TABLE `hd_button_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data` text,
  `title` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hd_button_data` WRITE;
/*!40000 ALTER TABLE `hd_button_data` DISABLE KEYS */;

INSERT INTO `hd_button_data` (`id`, `data`, `title`, `status`)
VALUES
	(1,'{\"button\":[{\"type\":\"click\",\"name\":\"今日歌曲\",\"key\":\"V1001_TODAY_MUSIC\"},{\"type\":\"view\",\"name\":\"后盾人\",\"url\":\"http://www.houdunren.com\",\"sub_button\":[{\"type\":\"view\",\"name\":\"PHP\",\"url\":\"http://www.houdunren.com/\"},{\"type\":\"view\",\"name\":\"HTML5\",\"url\":\"http://www.houdunren.com/\"}]}]}','a',0),
	(2,'{\"button\":[{\"type\":\"click\",\"name\":\"今日歌曲\",\"key\":\"V1001_TODAY_MUSIC\"},{\"type\":\"view\",\"name\":\"后盾人\",\"url\":\"http://www.houdunren.com\",\"sub_button\":[{\"type\":\"view\",\"name\":\"PHP\",\"url\":\"http://www.houdunren.com/\"},{\"type\":\"view\",\"name\":\"HTML5\",\"url\":\"http://www.houdunren.com/\"}]}]}','测试',0),
	(3,'{\"button\":[{\"type\":\"click\",\"name\":\"今日歌曲\",\"key\":\"V1001_TODAY_MUSIC\"},{\"type\":\"view\",\"name\":\"后盾人\",\"url\":\"http://www.houdunren.com\",\"sub_button\":[{\"type\":\"view\",\"name\":\"PHP\",\"url\":\"http://www.houdunren.com/\"},{\"type\":\"view\",\"name\":\"HTML5\",\"url\":\"http://www.houdunren.com/\"}]}]}','sdds',0),
	(4,'{\"button\":[{\"type\":\"click\",\"name\":\"今日歌曲\",\"key\":\"V1001_TODAY_MUSIC\"},{\"type\":\"view\",\"name\":\"后盾人\",\"url\":\"http://www.houdunren.com\",\"sub_button\":[{\"type\":\"view\",\"name\":\"PHP\",\"url\":\"http://www.houdunren.com/\"},{\"type\":\"view\",\"name\":\"HTML5\",\"url\":\"http://www.houdunren.com/\"}]}]}','sdds',0),
	(5,'{\"button\":[{\"type\":\"view\",\"name\":\"后盾\",\"key\":\"\",\"url\":\"http://baidu.com\"}]}','你好',0),
	(6,'{\"button\":[{\"type\":\"view\",\"name\":\"\\b视频\",\"key\":\"\",\"sub_button\":[{\"type\":\"view\",\"name\":\"PHP\",\"key\":\"\",\"url\":\"http://qq.com\"},{\"type\":\"view\",\"name\":\"LINUX\",\"key\":\"\",\"url\":\"http://qq.com\"}]},{\"type\":\"view\",\"name\":\"实战\",\"key\":\"\",\"url\":\"http://qq.com\"},{\"type\":\"view\",\"name\":\"腾讯\",\"key\":\"\",\"url\":\"http://qq.com\"}]}','活动营销',1),
	(7,'{\"button\":[{\"type\":\"view\",\"name\":\"后盾\\b视频\",\"key\":\"\",\"sub_button\":[{\"type\":\"view\",\"name\":\"PHP\",\"key\":\"\",\"url\":\"http://qq.com\"},{\"type\":\"view\",\"name\":\"LINUX\",\"key\":\"\",\"url\":\"http://qq.com\"}]},{\"type\":\"view\",\"name\":\"实战\",\"key\":\"\",\"url\":\"http://qq.com\"},{\"type\":\"click\",\"name\":\"关键词\",\"key\":\"a\",\"url\":\"http://baidu.com\"}]}','活动营销22',0);

/*!40000 ALTER TABLE `hd_button_data` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hd_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hd_config`;

CREATE TABLE `hd_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `system` text COMMENT '网站配置',
  `wechat` text COMMENT '微信配置',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hd_config` WRITE;
/*!40000 ALTER TABLE `hd_config` DISABLE KEYS */;

INSERT INTO `hd_config` (`id`, `system`, `wechat`)
VALUES
	(1,'{\"webname\":\"后盾网\",\"icp\":\"京ICP备8899\",\"tel\":\"古经理: 13910959565\"}','{\"token\":\"houdunren\",\"appid\":\"wxc47243ed572e273d\",\"appsecret\":\"1c72ad236f72c70e347343653410934b\"}');

/*!40000 ALTER TABLE `hd_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hd_keyword
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hd_keyword`;

CREATE TABLE `hd_keyword` (
  `rid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(20) DEFAULT NULL COMMENT '关键词内容',
  `module` varchar(20) DEFAULT NULL COMMENT '模块的标识',
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hd_keyword` WRITE;
/*!40000 ALTER TABLE `hd_keyword` DISABLE KEYS */;

INSERT INTO `hd_keyword` (`rid`, `keyword`, `module`)
VALUES
	(1,'a','Text'),
	(2,'hd','Text'),
	(3,'b','Text'),
	(4,'c','Text'),
	(5,'f','Text');

/*!40000 ALTER TABLE `hd_keyword` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hd_module
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hd_module`;

CREATE TABLE `hd_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `actions` text,
  `message` tinyint(1) DEFAULT NULL COMMENT '是否处理微信消息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模块数据表（已经安装)';

LOCK TABLES `hd_module` WRITE;
/*!40000 ALTER TABLE `hd_module` DISABLE KEYS */;

INSERT INTO `hd_module` (`id`, `title`, `name`, `actions`, `message`)
VALUES
	(21,'基本功能','base','[{\"title\":\"系统回复\",\"name\":\"system\"}]',0),
	(22,'文本回复','text','[]',1),
	(31,'微信菜单','button','[{\"title\":\"菜单设计\",\"name\":\"lists\"}]',0),
	(32,'微官网','news','[{\"title\":\"栏目管理\",\"name\":\"category\"},{\"title\":\"文章管理\",\"name\":\"article\"}]',0);

/*!40000 ALTER TABLE `hd_module` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hd_news_article
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hd_news_article`;

CREATE TABLE `hd_news_article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `click` mediumint(9) DEFAULT NULL,
  `content` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hd_news_article` WRITE;
/*!40000 ALTER TABLE `hd_news_article` DISABLE KEYS */;

INSERT INTO `hd_news_article` (`id`, `title`, `click`, `content`)
VALUES
	(4,'sdfsdf',33,'<p>dsdsdssd</p>');

/*!40000 ALTER TABLE `hd_news_article` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hd_news_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hd_news_category`;

CREATE TABLE `hd_news_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hd_news_category` WRITE;
/*!40000 ALTER TABLE `hd_news_category` DISABLE KEYS */;

INSERT INTO `hd_news_category` (`id`, `catname`)
VALUES
	(1,'新闻'),
	(2,'游戏 ');

/*!40000 ALTER TABLE `hd_news_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hd_text_contents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hd_text_contents`;

CREATE TABLE `hd_text_contents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rid` int(11) DEFAULT NULL,
  `content` varchar(200) DEFAULT NULL COMMENT '回复内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `hd_text_contents` WRITE;
/*!40000 ALTER TABLE `hd_text_contents` DISABLE KEYS */;

INSERT INTO `hd_text_contents` (`id`, `rid`, `content`)
VALUES
	(1,1,'这是微信开发课程，希望大家认真练习，举一反三'),
	(2,2,'后盾人，人人做后盾'),
	(3,3,'b'),
	(4,4,'c');

/*!40000 ALTER TABLE `hd_text_contents` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
