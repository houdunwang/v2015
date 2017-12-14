<?php
@include("../../inc/header.php");

/*
		SoftName : EmpireBak
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `phome_enewsbqclass`;");
E_C("CREATE TABLE `phome_enewsbqclass` (
  `classid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `classname` char(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsbqclass` values('1','信息调用');");
E_D("replace into `phome_enewsbqclass` values('2','栏目调用');");
E_D("replace into `phome_enewsbqclass` values('3','非信息调用');");
E_D("replace into `phome_enewsbqclass` values('4','其它标签');");

@include("../../inc/footer.php");
?>