<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewsuser`;");
E_C("CREATE TABLE `phome_enewsuser` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `rnd` varchar(20) NOT NULL DEFAULT '',
  `adminclass` mediumtext NOT NULL,
  `groupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `checked` tinyint(1) NOT NULL DEFAULT '0',
  `styleid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `filelevel` tinyint(1) NOT NULL DEFAULT '0',
  `salt` varchar(8) NOT NULL DEFAULT '',
  `loginnum` int(10) unsigned NOT NULL DEFAULT '0',
  `lasttime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(20) NOT NULL DEFAULT '',
  `truename` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(120) NOT NULL DEFAULT '',
  `classid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pretime` int(10) unsigned NOT NULL DEFAULT '0',
  `preip` varchar(20) NOT NULL DEFAULT '',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
  `addip` varchar(20) NOT NULL DEFAULT '',
  `userprikey` varchar(50) NOT NULL DEFAULT '',
  `salt2` varchar(20) NOT NULL DEFAULT '',
  `lastipport` varchar(6) NOT NULL DEFAULT '',
  `preipport` varchar(6) NOT NULL DEFAULT '',
  `addipport` varchar(6) NOT NULL DEFAULT '',
  `uprnd` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsuser` values('1',0x61646d696e,0x3763656234323136626465373366633631643465353731363331366330643566,0x514b50544856424b4c7a4267597967324f316b32,'','1','0','1','0',0x5852524634624973,'8','1513609810',0x3a3a31,'','','0','1513161846',0x3a3a31,'1512637513',0x3a3a31,0x4b546e6a537879377470666957676d616f32657930444c3538746c387368526c6d69696c444e6a4f3979563174544a75,0x5570584c3775454734393034664e7267764e6737,0x3631333932,0x3632313133,0x3532363533,'');");
E_D("replace into `phome_enewsuser` values('2',0x686f7564756e72656e,0x3236313533663332643331643431353635373639356233363330313339623065,0x38615159326c7842506c30705a76616d6a317774,0x7c,'2','0','1','0',0x5a75346337394e4a,'0','0','','','','0','0','','1512640109',0x3a3a31,0x6253796d67766c3450724339514e784d30353437766e5057314d57484e7230545a75595a33536d36394e6d5452316d43,0x6174736377424b50623857557678575747424941,0x3535353033,0x3535353033,0x3535353033,'');");

require("../../inc/footer.php");
?>