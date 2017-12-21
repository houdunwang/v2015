<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewspl_set`;");
E_C("CREATE TABLE `phome_enewspl_set` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pltime` smallint(5) unsigned NOT NULL DEFAULT '0',
  `plsize` smallint(5) unsigned NOT NULL DEFAULT '0',
  `plincludesize` smallint(5) unsigned NOT NULL DEFAULT '0',
  `plkey_ok` tinyint(1) NOT NULL DEFAULT '0',
  `plface` text NOT NULL,
  `plfacenum` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `plgroupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `plclosewords` text NOT NULL,
  `plf` text NOT NULL,
  `plmustf` text NOT NULL,
  `pldatatbs` text NOT NULL,
  `defpltempid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pl_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pldeftb` smallint(5) unsigned NOT NULL DEFAULT '0',
  `plurl` varchar(200) NOT NULL DEFAULT '',
  `plmaxfloor` smallint(5) unsigned NOT NULL DEFAULT '0',
  `plquotetemp` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewspl_set` values('1','20','500','0','1',0x7c7c5b7e652e6a797e5d2323312e6769667c7c5b7e652e6b717e5d2323322e6769667c7c5b7e652e73657e5d2323332e6769667c7c5b7e652e73717e5d2323342e6769667c7c5b7e652e6c687e5d2323352e6769667c7c5b7e652e6b617e5d2323362e6769667c7c5b7e652e68687e5d2323372e6769667c7c5b7e652e79737e5d2323382e6769667c7c5b7e652e6e677e5d2323392e6769667c7c5b7e652e6f747e5d232331302e6769667c7c,'10','0','','','',0x2c312c,'1','12','1',0x2f652f706c2f,'0',0x3c64697620636c6173733d5c2265636f6d6d656e745c223e0d0a3c7370616e20636c6173733d5c2265636f6d6d656e74617574686f725c223ee7bd91e58f8b205b212d2d757365726e616d652d2d5d20e79a84e58e9fe69687efbc9a3c2f7370616e3e0d0a3c7020636c6173733d5c2265636f6d6d656e74746578745c223e5b212d2d706c746578742d2d5d3c2f703e0d0a3c2f6469763e);");

require("../../inc/footer.php");
?>