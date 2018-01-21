<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewsplayer`;");
E_C("CREATE TABLE `phome_enewsplayer` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `player` varchar(30) NOT NULL DEFAULT '',
  `filename` varchar(20) NOT NULL DEFAULT '',
  `bz` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsplayer` values('1',0x5265616c506c61796572,0x7265616c706c617965722e706870,0x5265616c506c61796572e692ade694bee599a8);");
E_D("replace into `phome_enewsplayer` values('2',0x4d65646961506c61796572,0x6d65646961706c617965722e706870,0x4d65646961506c61796572e692ade694bee599a8);");
E_D("replace into `phome_enewsplayer` values('3',0x464c415348,0x666c61736865722e706870,0x464c415348e692ade694bee599a8);");
E_D("replace into `phome_enewsplayer` values('4',0x464c56e692ade694bee599a8,0x666c7665722e706870,0x464c56e692ade694bee599a8);");

require("../../inc/footer.php");
?>