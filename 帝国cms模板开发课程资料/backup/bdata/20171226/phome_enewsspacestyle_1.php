<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewsspacestyle`;");
E_C("CREATE TABLE `phome_enewsspacestyle` (
  `styleid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `stylename` varchar(30) NOT NULL DEFAULT '',
  `stylepic` varchar(255) NOT NULL DEFAULT '',
  `stylesay` varchar(255) NOT NULL DEFAULT '',
  `stylepath` varchar(30) NOT NULL DEFAULT '0',
  `isdefault` tinyint(1) NOT NULL DEFAULT '0',
  `membergroup` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`styleid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsspacestyle` values('1',0xe9bb98e8aea4e4b8aae4babae7a9bae997b4e6a8a1e69dbf,'',0xe9bb98e8aea4e4b8aae4babae7a9bae997b4e6a8a1e69dbf,0x64656661756c74,'1',0x2c312c322c);");
E_D("replace into `phome_enewsspacestyle` values('2',0xe9bb98e8aea4e4bc81e4b89ae7a9bae997b4e6a8a1e69dbf,'',0xe9bb98e8aea4e4bc81e4b89ae7a9bae997b4e6a8a1e69dbf,0x636f6d64656661756c74,'0',0x2c332c342c);");

require("../../inc/footer.php");
?>