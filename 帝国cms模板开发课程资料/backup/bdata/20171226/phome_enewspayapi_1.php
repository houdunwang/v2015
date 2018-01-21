<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewspayapi`;");
E_C("CREATE TABLE `phome_enewspayapi` (
  `payid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `paytype` varchar(20) NOT NULL DEFAULT '',
  `myorder` tinyint(4) NOT NULL DEFAULT '0',
  `payfee` varchar(10) NOT NULL DEFAULT '',
  `payuser` varchar(60) NOT NULL DEFAULT '',
  `partner` varchar(60) NOT NULL DEFAULT '',
  `paykey` varchar(120) NOT NULL DEFAULT '',
  `paylogo` varchar(200) NOT NULL DEFAULT '',
  `paysay` text NOT NULL,
  `payname` varchar(120) NOT NULL DEFAULT '',
  `isclose` tinyint(1) NOT NULL DEFAULT '0',
  `payemail` varchar(120) NOT NULL DEFAULT '',
  `paymethod` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`payid`),
  UNIQUE KEY `paytype` (`paytype`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewspayapi` values('1',0x74656e706179,'1','0','','','','',0xe8b4a2e4bb98e9809aefbc887777772e74656e7061792e636f6defbc89202d20e885bee8aeafe69797e4b88be59ca8e7babfe694afe4bb98e5b9b3e58fb0efbc8ce9809ae8bf87e59bbde5aeb6e69d83e5a881e5ae89e585a8e8aea4e8af81efbc8ce694afe68c81e59084e5a4a7e993b6e8a18ce7bd91e4b88ae694afe4bb98e38082,0xe8b4a2e4bb98e9809a,'0','','0');");
E_D("replace into `phome_enewspayapi` values('2',0x6368696e6162616e6b,'2','0','','','','',0xe7bd91e993b6e59ca8e7babfe4b88ee4b8ade59bbde5b7a5e59586e993b6e8a18ce38081e68b9be59586e993b6e8a18ce38081e4b8ade59bbde5bbbae8aebee993b6e8a18ce38081e5869ce4b89ae993b6e8a18ce38081e6b091e7949fe993b6e8a18ce7ad89e695b0e58d81e5aeb6e98791e89e8de69cbae69e84e8bebee68890e58d8fe8aeaee38082e585a8e99da2e694afe68c81e585a8e59bbd3139e5aeb6e993b6e8a18ce79a84e4bfa1e794a8e58da1e58f8ae5809fe8aeb0e58da1e5ae9ee78eb0e7bd91e4b88ae694afe4bb98e38082efbc88e7bd91e59d80efbc9a687474703a2f2f7777772e6368696e6162616e6b2e636f6d2e636eefbc89,0xe7bd91e993b6e59ca8e7babf,'0','','0');");
E_D("replace into `phome_enewspayapi` values('3',0x616c69706179,'0','0','','','','',0xe694afe4bb98e5ae9de7bd91e7ab99287777772e616c697061792e636f6d2920e698afe59bbde58685e58588e8bf9be79a84e7bd91e4b88ae694afe4bb98e5b9b3e58fb0e38082,0xe694afe4bb98e5ae9de68ea5e58fa3,'0','','1');");

require("../../inc/footer.php");
?>