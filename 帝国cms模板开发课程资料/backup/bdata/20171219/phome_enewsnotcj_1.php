<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_enewsnotcj`;");
E_C("CREATE TABLE `phome_enewsnotcj` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `word` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsnotcj` values('1',0x3c696e70757420747970653d68696464656e2076616c75653d27e6aca2e8bf8ee4bdbfe794a8e5b89de59bbde7bd91e7ab99e7aea1e79086e7b3bbe7bb9fefbc9a7777772e70686f6d652e6e6574273e);");
E_D("replace into `phome_enewsnotcj` values('2',0x3c70686f6d6520e5b89de59bbde7bd91e7ab99e7aea1e79086e7b3bbe7bb9f2c70686f6d652e6e65743e);");
E_D("replace into `phome_enewsnotcj` values('3',0x3c212d2de5b89de59bbd434d532c70686f6d652e6e65742d2d3e);");
E_D("replace into `phome_enewsnotcj` values('4',0x3c7461626c65207374796c653d646973706c61793a6e6f6e653e3c74723e3c74643e0d0a456d7069726520434d532c70686f6d652e6e65740d0a3c2f74643e3c2f74723e3c2f7461626c653e);");
E_D("replace into `phome_enewsnotcj` values('5',0x3c646976207374796c653d646973706c61793a6e6f6e653e0d0ae68ba5e69c89e5b89de59bbde4b880e58887efbc8ce79a86e69c89e58fafe883bde38082e6aca2e8bf8ee8aebfe997ae70686f6d652e6e65740d0a3c2f6469763e);");

require("../../inc/footer.php");
?>