<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_ecms_slide`;");
E_C("CREATE TABLE `phome_ecms_slide` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ttid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `onclick` int(10) unsigned NOT NULL DEFAULT '0',
  `plnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `totaldown` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `newspath` char(20) NOT NULL DEFAULT '',
  `filename` char(36) NOT NULL DEFAULT '',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(20) NOT NULL DEFAULT '',
  `firsttitle` tinyint(1) NOT NULL DEFAULT '0',
  `isgood` tinyint(1) NOT NULL DEFAULT '0',
  `ispic` tinyint(1) NOT NULL DEFAULT '0',
  `istop` tinyint(1) NOT NULL DEFAULT '0',
  `isqf` tinyint(1) NOT NULL DEFAULT '0',
  `ismember` tinyint(1) NOT NULL DEFAULT '0',
  `isurl` tinyint(1) NOT NULL DEFAULT '0',
  `truetime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastdotime` int(10) unsigned NOT NULL DEFAULT '0',
  `havehtml` tinyint(1) NOT NULL DEFAULT '0',
  `groupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `userfen` smallint(5) unsigned NOT NULL DEFAULT '0',
  `titlefont` char(14) NOT NULL DEFAULT '',
  `titleurl` char(200) NOT NULL DEFAULT '',
  `stb` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `fstb` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `restb` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `keyboard` char(80) NOT NULL DEFAULT '',
  `title` char(100) NOT NULL DEFAULT '',
  `newstime` int(10) unsigned NOT NULL DEFAULT '0',
  `titlepic` char(120) NOT NULL DEFAULT '',
  `introduce` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `classid` (`classid`),
  KEY `newstime` (`newstime`),
  KEY `ttid` (`ttid`),
  KEY `firsttitle` (`firsttitle`),
  KEY `isgood` (`isgood`),
  KEY `ispic` (`ispic`),
  KEY `useridis` (`userid`,`ismember`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8");
E_D("replace into `phome_ecms_slide` values('1','3','0','0','0','0',0x323031372d31322d3133,0x31,'1',0x61646d696e,'0','0','1','0','0','0','1','1513157231','1513162376','1','0','0',0x2c627c,0x687474703a2f2f7777772e686f7564756e77616e672e636f6d,'1','1','1',0xe5908ee79bbee4baba,0xe5908ee79bbee4baba20e4babae4babae5819ae5908ee79bbe,'1513157180',0x2f642f66696c652f736c6964652f323031372d31322d31332f63323434613363353565363230383939353838633938383065376536363932372e6a7067,0xe5908ee79bbee4baba20e4babae4babae5819ae5908ee79bbe0d0ae5908ee79bbee4baba20e4babae4babae5819ae5908ee79bbe0d0ae5908ee79bbee4baba20e4babae4babae5819ae5908ee79bbe);");
E_D("replace into `phome_ecms_slide` values('2','3','0','0','0','0',0x323031372d31322d3133,0x32,'1',0x61646d696e,'0','0','1','0','0','0','1','1513157308','1513157308','1','0','0',0x2c697c,0x687474703a2f2f7777772e686f7564756e72656e2e636f6d,'1','1','1',0xe5b9b4e7bb882ce79b9be4bc9a,0xe5b9b4e7bb88e79b9be4bc9a2ce68da2e4b8aae5a7bfe58abfe8bf8ee696b0e5b9b4,'1513157234',0x2f642f66696c652f736c6964652f323031372d31322d31332f37316637613463366663633538346466633434393463336339393362356338392e6a7067,0xe5b9b4e7bb88e79b9be4bc9a2ce68da2e4b8aae5a7bfe58abfe8bf8ee696b0e5b9b4e5b9b4e7bb88e79b9be4bc9a2ce68da2e4b8aae5a7bfe58abfe8bf8ee696b0e5b9b4e5b9b4e7bb88e79b9be4bc9a2ce68da2e4b8aae5a7bfe58abfe8bf8ee696b0e5b9b4e5b9b4e7bb88e79b9be4bc9a2ce68da2e4b8aae5a7bfe58abfe8bf8ee696b0e5b9b4);");
E_D("replace into `phome_ecms_slide` values('3','3','0','0','0','0',0x323031372d31322d3133,0x33,'1',0x61646d696e,'0','0','1','0','0','0','1','1513157389','1513157389','1','0','0',0x2c627c,0x687474703a2f2f6262732e686f7564756e77616e672e636f6d,'1','1','1',0xe59091e5869be5a4a7e58f942ce5ada6e4b9a0,0xe59091e5869be5a4a7e58f94e5b8a6e4bda0e5ada6e4b9a0207265616374206e6174697665,'1513157312',0x2f642f66696c652f736c6964652f323031372d31322d31332f34316262326336303462376262346236353734343465663439376631613635362e6a7067,0xe59091e5869be5a4a7e58f94e5b8a6e4bda0e5ada6e4b9a0207265616374206e6174697665e59091e5869be5a4a7e58f94e5b8a6e4bda0e5ada6e4b9a0207265616374206e6174697665e59091e5869be5a4a7e58f94e5b8a6e4bda0e5ada6e4b9a0207265616374206e6174697665e59091e5869be5a4a7e58f94e5b8a6e4bda0e5ada6e4b9a0207265616374206e6174697665e59091e5869be5a4a7e58f94e5b8a6e4bda0e5ada6e4b9a0207265616374206e6174697665);");

require("../../inc/footer.php");
?>