<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewsbqclass`;");
E_C("CREATE TABLE `phome_enewsbqclass` (
  `classid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `classname` char(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsbqclass` values('1',0xe4bfa1e681afe8b083e794a8);");
E_D("replace into `phome_enewsbqclass` values('2',0xe6a08fe79baee8b083e794a8);");
E_D("replace into `phome_enewsbqclass` values('3',0xe99d9ee4bfa1e681afe8b083e794a8);");
E_D("replace into `phome_enewsbqclass` values('4',0xe585b6e5ae83e6a087e7adbe);");

require("../../inc/footer.php");
?>