<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewsmembergroup`;");
E_C("CREATE TABLE `phome_enewsmembergroup` (
  `groupid` smallint(6) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(60) NOT NULL DEFAULT '',
  `level` smallint(6) NOT NULL DEFAULT '0',
  `checked` tinyint(1) NOT NULL DEFAULT '0',
  `favanum` smallint(6) NOT NULL DEFAULT '0',
  `daydown` int(11) NOT NULL DEFAULT '0',
  `msglen` int(11) NOT NULL DEFAULT '0',
  `msgnum` int(11) NOT NULL DEFAULT '0',
  `canreg` tinyint(1) NOT NULL DEFAULT '0',
  `formid` smallint(6) NOT NULL DEFAULT '0',
  `regchecked` tinyint(1) NOT NULL DEFAULT '0',
  `spacestyleid` smallint(6) NOT NULL DEFAULT '0',
  `dayaddinfo` smallint(6) NOT NULL DEFAULT '0',
  `infochecked` tinyint(1) NOT NULL DEFAULT '0',
  `plchecked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsmembergroup` values('1',0xe699aee9809ae4bc9ae59198,'1','0','120','0','255','50','1','1','0','1','0','0','0');");
E_D("replace into `phome_enewsmembergroup` values('2',0x564950e4bc9ae59198,'2','0','200','0','255','120','0','1','0','1','0','0','0');");
E_D("replace into `phome_enewsmembergroup` values('3',0xe4bc81e4b89ae4bc9ae59198,'1','0','120','0','255','50','1','2','0','2','0','0','0');");
E_D("replace into `phome_enewsmembergroup` values('4',0xe4bc81e4b89a564950e4bc9ae59198,'2','0','200','0','255','120','0','2','0','2','0','0','0');");

require("../../inc/footer.php");
?>