<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewsdolog`;");
E_C("CREATE TABLE `phome_enewsdolog` (
  `logid` bigint(20) NOT NULL AUTO_INCREMENT,
  `logip` varchar(20) NOT NULL DEFAULT '',
  `logtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `username` varchar(30) NOT NULL DEFAULT '',
  `enews` varchar(30) NOT NULL DEFAULT '',
  `doing` varchar(255) NOT NULL DEFAULT '',
  `pubid` bigint(16) unsigned NOT NULL DEFAULT '0',
  `ipport` varchar(6) NOT NULL DEFAULT '',
  PRIMARY KEY (`logid`),
  KEY `pubid` (`pubid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsdolog` values('1',0x3a3a31,'2017-12-07 17:06:11',0x61646d696e,0x6c6f67696e,0x2d2d2d,'0',0x3532363834);");
E_D("replace into `phome_enewsdolog` values('2',0x3a3a31,'2017-12-07 17:14:10',0x61646d696e,0x536574456e657773,0x2d2d2d,'0',0x3533303333);");
E_D("replace into `phome_enewsdolog` values('3',0x3a3a31,'2017-12-07 17:23:26',0x61646d696e,0x42616b457865,0x64626e616d653d656d70697265636d73,'0',0x3533373531);");

require("../../inc/footer.php");
?>