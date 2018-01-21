<?php
@include("../../inc/header.php");

/*
		SoftName : EmpireBak
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `phome_enewsclassnavcache`;");
E_C("CREATE TABLE `phome_enewsclassnavcache` (
  `navtype` char(16) NOT NULL DEFAULT '',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `modid` smallint(5) unsigned NOT NULL DEFAULT '0',
  KEY `navtype` (`navtype`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsclassnavcache` values('listclass','0','0');");
E_D("replace into `phome_enewsclassnavcache` values('listenews','0','0');");
E_D("replace into `phome_enewsclassnavcache` values('jsclass','0','0');");

@include("../../inc/footer.php");
?>