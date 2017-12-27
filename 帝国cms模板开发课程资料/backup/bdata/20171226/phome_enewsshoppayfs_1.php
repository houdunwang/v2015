<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewsshoppayfs`;");
E_C("CREATE TABLE `phome_enewsshoppayfs` (
  `payid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `payname` varchar(60) NOT NULL DEFAULT '',
  `payurl` varchar(255) NOT NULL DEFAULT '',
  `paysay` text NOT NULL,
  `userpay` tinyint(1) NOT NULL DEFAULT '0',
  `userfen` tinyint(1) NOT NULL DEFAULT '0',
  `isclose` tinyint(1) NOT NULL DEFAULT '0',
  `isdefault` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`payid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsshoppayfs` values('1',0xe982aee694bfe6b187e6acbe,'',0xe982aee694bfe6b187e6acbee59cb0e59d803a2a2a2a2a2a2a,'0','0','0','0');");
E_D("replace into `phome_enewsshoppayfs` values('2',0xe993b6e8a18ce8bdace5b890,'',0xe993b6e8a18ce8bdace5b890e5b890e58fb73a2a2a2a2a2a2a,'0','0','0','0');");
E_D("replace into `phome_enewsshoppayfs` values('3',0xe7bd91e993b6e694afe4bb98,0x2f652f7061796170692f53686f705061792e7068703f706179747970653d616c69706179,0x3c703ee7bd91e993b6e694afe4bb983c2f703e,'0','0','0','1');");
E_D("replace into `phome_enewsshoppayfs` values('4',0xe9a284e4bb98e6acbee694afe4bb98,'',0xe9a284e4bb98e6acbee694afe4bb98,'1','0','0','0');");
E_D("replace into `phome_enewsshoppayfs` values('5',0xe8b4a7e588b0e4bb98e6acbe28e68896e4b88ae997a8e694b6e6acbe29,'',0xe8b4a7e588b0e4bb98e6acbe28e68896e4b88ae997a8e694b6e6acbe29e8afb4e6988e,'0','0','0','0');");
E_D("replace into `phome_enewsshoppayfs` values('6',0xe782b9e695b0e8b4ade4b9b0,'',0xe782b9e695b0e8b4ade4b9b0,'0','1','0','0');");

require("../../inc/footer.php");
?>