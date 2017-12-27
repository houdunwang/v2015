<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewslog`;");
E_C("CREATE TABLE `phome_enewslog` (
  `loginid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `logintime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `loginip` varchar(20) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(30) NOT NULL DEFAULT '',
  `loginauth` tinyint(1) NOT NULL DEFAULT '0',
  `ipport` varchar(6) NOT NULL DEFAULT '',
  PRIMARY KEY (`loginid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewslog` values('1',0x61646d696e,'2017-12-07 17:06:11',0x3a3a31,'1','','0',0x3532363834);");
E_D("replace into `phome_enewslog` values('2',0x61646d696e,'2017-12-08 15:54:37',0x3a3a31,'1','','0',0x3539363732);");
E_D("replace into `phome_enewslog` values('3',0x61646d696e,'2017-12-08 15:55:25',0x3a3a31,'1','','0',0x3539373538);");
E_D("replace into `phome_enewslog` values('4',0x61646d696e,'2017-12-08 18:24:34',0x3a3a31,'1','','0',0x3634343135);");
E_D("replace into `phome_enewslog` values('5',0x61646d696e,'2017-12-13 15:57:56',0x3a3a31,'0','','0',0x3530363232);");
E_D("replace into `phome_enewslog` values('6',0x61646d696e,'2017-12-13 15:58:02',0x3a3a31,'1','','0',0x3530363232);");
E_D("replace into `phome_enewslog` values('7',0x61646d696e,'2017-12-13 16:27:17',0x3a3a31,'1','','0',0x3532303236);");
E_D("replace into `phome_enewslog` values('8',0x61646d696e,'2017-12-13 18:44:06',0x3a3a31,'1','','0',0x3632313133);");
E_D("replace into `phome_enewslog` values('9',0x61646d696e,'2017-12-18 23:10:10',0x3a3a31,'1','','0',0x3631333932);");
E_D("replace into `phome_enewslog` values('10',0x61646d696e,'2017-12-21 17:04:10',0x3a3a31,'1','','0',0x3534353239);");
E_D("replace into `phome_enewslog` values('11',0x61646d696e,'2017-12-22 16:51:45',0x3a3a31,'0','','0',0x3531343138);");
E_D("replace into `phome_enewslog` values('12',0x61646d696e,'2017-12-22 16:51:51',0x3a3a31,'0','','0',0x3531343138);");
E_D("replace into `phome_enewslog` values('13',0x61646d696e,'2017-12-22 16:51:56',0x3a3a31,'1','','0',0x3531343239);");
E_D("replace into `phome_enewslog` values('14',0x61646d696e,'2017-12-26 16:22:19',0x3a3a31,'1','','0',0x3631393536);");

require("../../inc/footer.php");
?>