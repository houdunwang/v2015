<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewstable`;");
E_C("CREATE TABLE `phome_enewstable` (
  `tid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tbname` varchar(60) NOT NULL DEFAULT '',
  `tname` varchar(60) NOT NULL DEFAULT '',
  `tsay` text NOT NULL,
  `isdefault` tinyint(1) NOT NULL DEFAULT '0',
  `datatbs` text NOT NULL,
  `deftb` varchar(6) NOT NULL DEFAULT '',
  `yhid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `intb` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewstable` values('1',0x6e657773,0xe696b0e997bbe7b3bbe7bb9fe695b0e68daee8a1a8,0xe696b0e997bbe7b3bbe7bb9fe695b0e68daee8a1a8,'1',0x2c312c,0x31,'0','1','0');");
E_D("replace into `phome_enewstable` values('2',0x646f776e6c6f6164,0xe4b88be8bdbde7b3bbe7bb9fe695b0e68daee8a1a8,0xe4b88be8bdbde7b3bbe7bb9fe695b0e68daee8a1a8,'0',0x2c312c,0x31,'0','2','0');");
E_D("replace into `phome_enewstable` values('3',0x70686f746f,0xe59bbee78987e7b3bbe7bb9fe695b0e68daee8a1a8,0xe59bbee78987e7b3bbe7bb9fe695b0e68daee8a1a8,'0',0x2c312c,0x31,'0','3','0');");
E_D("replace into `phome_enewstable` values('4',0x666c617368,0x464c415348e7b3bbe7bb9fe695b0e68daee8a1a8,0x464c415348e7b3bbe7bb9fe695b0e68daee8a1a8,'0',0x2c312c,0x31,'0','4','0');");
E_D("replace into `phome_enewstable` values('5',0x6d6f766965,0xe794b5e5bdb1e7b3bbe7bb9fe695b0e68daee8a1a8,0xe794b5e5bdb1e7b3bbe7bb9fe695b0e68daee8a1a8,'0',0x2c312c,0x31,'0','5','0');");
E_D("replace into `phome_enewstable` values('6',0x73686f70,0xe59586e59f8ee7b3bbe7bb9fe695b0e68daee8a1a8,0xe59586e59f8ee7b3bbe7bb9fe695b0e68daee8a1a8,'0',0x2c312c,0x31,'0','6','0');");
E_D("replace into `phome_enewstable` values('7',0x61727469636c65,0xe69687e7aba0e7b3bbe7bb9fe695b0e68daee8a1a8,0xe69687e7aba0e7b3bbe7bb9fe695b0e68daee8a1a828e58685e5aeb9e5ad98e69687e69cac29,'0',0x2c312c,0x31,'0','7','0');");
E_D("replace into `phome_enewstable` values('8',0x696e666f,0xe58886e7b1bbe4bfa1e681afe695b0e68daee8a1a8,0xe58886e7b1bbe4bfa1e681afe695b0e68daee8a1a8,'0',0x2c312c,0x31,'0','8','0');");
E_D("replace into `phome_enewstable` values('10',0x736c696465,0xe8bdaee692ade59bbee695b0e68daee8a1a8,0xe5898de58fb0e8bdaee692ade59bbee695b0e68daee8a1a8,'0',0x2c312c,0x31,'0','9','0');");

require("../../inc/footer.php");
?>