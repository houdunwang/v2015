<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewswapstyle`;");
E_C("CREATE TABLE `phome_enewswapstyle` (
  `styleid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `stylename` varchar(60) NOT NULL DEFAULT '',
  `path` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`styleid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewswapstyle` values('1',0xe696b0e997bbe6a8a1e69dbf,'1');");
E_D("replace into `phome_enewswapstyle` values('2',0xe58886e7b1bbe4bfa1e681afe6a8a1e69dbf,'2');");

require("../../inc/footer.php");
?>