<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewsfeedbackf`;");
E_C("CREATE TABLE `phome_enewsfeedbackf` (
  `fid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `f` varchar(30) NOT NULL DEFAULT '',
  `fname` varchar(30) NOT NULL DEFAULT '',
  `fform` varchar(20) NOT NULL DEFAULT '',
  `fzs` varchar(255) NOT NULL DEFAULT '',
  `myorder` smallint(6) NOT NULL DEFAULT '0',
  `ftype` varchar(30) NOT NULL DEFAULT '',
  `flen` varchar(20) NOT NULL DEFAULT '',
  `fformsize` varchar(12) NOT NULL DEFAULT '',
  `fvalue` text NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsfeedbackf` values('1',0x7469746c65,0xe6a087e9a298,0x74657874,'','7',0x56415243484152,0x313230,'','');");
E_D("replace into `phome_enewsfeedbackf` values('2',0x73617974657874,0xe58685e5aeb9,0x7465787461726561,'','8',0x54455854,'','','');");
E_D("replace into `phome_enewsfeedbackf` values('3',0x6e616d65,0xe5a793e5908d,0x74657874,'','0',0x56415243484152,0x3330,'','');");
E_D("replace into `phome_enewsfeedbackf` values('4',0x656d61696c,0xe982aee7aeb1,0x74657874,'','3',0x56415243484152,0x3830,'','');");
E_D("replace into `phome_enewsfeedbackf` values('5',0x6d7963616c6c,0xe794b5e8af9d,0x74657874,'','4',0x56415243484152,0x3330,'','');");
E_D("replace into `phome_enewsfeedbackf` values('6',0x686f6d6570616765,0xe7bd91e7ab99,0x74657874,'','5',0x56415243484152,0x313630,'','');");
E_D("replace into `phome_enewsfeedbackf` values('7',0x636f6d70616e79,0xe585ace58fb8e5908de7a7b0,0x74657874,'','2',0x56415243484152,0x3830,'','');");
E_D("replace into `phome_enewsfeedbackf` values('8',0x61646472657373,0xe88194e7b3bbe59cb0e59d80,0x74657874,'','6',0x56415243484152,0x323535,'','');");
E_D("replace into `phome_enewsfeedbackf` values('9',0x6a6f62,0xe8818ce58aa1,0x74657874,'','1',0x56415243484152,0x3336,'','');");

require("../../inc/footer.php");
?>