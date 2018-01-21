<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewsjstemp`;");
E_C("CREATE TABLE `phome_enewsjstemp` (
  `tempid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tempname` varchar(30) NOT NULL DEFAULT '',
  `temptext` mediumtext NOT NULL,
  `classid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `isdefault` tinyint(1) NOT NULL DEFAULT '0',
  `showdate` varchar(20) NOT NULL DEFAULT '',
  `modid` smallint(6) NOT NULL DEFAULT '0',
  `subnews` smallint(6) NOT NULL DEFAULT '0',
  `subtitle` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tempid`),
  KEY `classid` (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsjstemp` values('1',0xe9bb98e8aea46a73e6a8a1e69dbf,0x5b212d2d656d706972656e6577732e6c69737474656d702d2d5d3c6c693e3c6120687265663d5c225b212d2d7469746c6575726c2d2d5d5c22207469746c653d5c225b212d2d6f6c647469746c652d2d5d5c223e5b212d2d7469746c652d2d5d3c2f613e3c2f6c693e5b212d2d656d706972656e6577732e6c69737474656d702d2d5d,'0','1',0x6d2d64,'1','0','32');");

require("../../inc/footer.php");
?>