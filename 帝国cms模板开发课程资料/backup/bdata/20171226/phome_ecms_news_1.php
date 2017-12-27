<?php
define('InEmpireBakData',TRUE);
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 5.1
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `phome_ecms_news`;");
E_C("CREATE TABLE `phome_ecms_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ttid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `onclick` int(10) unsigned NOT NULL DEFAULT '0',
  `plnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `totaldown` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `newspath` char(20) NOT NULL DEFAULT '',
  `filename` char(36) NOT NULL DEFAULT '',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` char(20) NOT NULL DEFAULT '',
  `firsttitle` tinyint(1) NOT NULL DEFAULT '0',
  `isgood` tinyint(1) NOT NULL DEFAULT '0',
  `ispic` tinyint(1) NOT NULL DEFAULT '0',
  `istop` tinyint(1) NOT NULL DEFAULT '0',
  `isqf` tinyint(1) NOT NULL DEFAULT '0',
  `ismember` tinyint(1) NOT NULL DEFAULT '0',
  `isurl` tinyint(1) NOT NULL DEFAULT '0',
  `truetime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastdotime` int(10) unsigned NOT NULL DEFAULT '0',
  `havehtml` tinyint(1) NOT NULL DEFAULT '0',
  `groupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `userfen` smallint(5) unsigned NOT NULL DEFAULT '0',
  `titlefont` char(14) NOT NULL DEFAULT '',
  `titleurl` char(200) NOT NULL DEFAULT '',
  `stb` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `fstb` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `restb` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `keyboard` char(80) NOT NULL DEFAULT '',
  `title` char(100) NOT NULL DEFAULT '',
  `newstime` int(10) unsigned NOT NULL DEFAULT '0',
  `titlepic` char(120) NOT NULL DEFAULT '',
  `ftitle` char(120) NOT NULL DEFAULT '',
  `smalltext` char(255) NOT NULL DEFAULT '',
  `ding` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `classid` (`classid`),
  KEY `newstime` (`newstime`),
  KEY `ttid` (`ttid`),
  KEY `firsttitle` (`firsttitle`),
  KEY `isgood` (`isgood`),
  KEY `ispic` (`ispic`),
  KEY `useridis` (`userid`,`ismember`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8");
E_D("replace into `phome_ecms_news` values('1','5','0','7','0','0',0x323031372d31322d3139,0x31,'1',0x61646d696e,'0','0','1','0','0','0','0','1513616974','1513621686','1','0','0',0x2c627c,0x2f652f616374696f6e2f53686f77496e666f2e7068703f636c61737369643d352669643d31,'1','1','1',0xe6af95e4b89ae5a4a7e59089,0xe7a59defbc9a3837e69c9fe6af95e4b89ae5a4a7e59089,'1513616924',0x2f642f66696c652f626c6f672f323031372d31322d31392f63613937613864646638636162646638323430313130346434643135326131632e6a7067,'',0xe58886e588abe697b6e588bbefbc8ce6b2a1e69c89e6849fe4bca4efbc8ce59ba0e4b8bae68891e4bbace4bf9de79599e4ba86e5b88ce69c9befbc8ce58886e588abe697b6e588bbefbc8ce6b2a1e69c89e7a6bbe588abefbc8ce59ba0e4b8bae68891e4bbace79599e4bd8fe4ba86e6b0b8e68192efbc8ce7a59d3837e69c9fe585a8e4bd93e5908ce5ada6e6af95e4b89ae5a4a7e5908921,'0');");
E_D("replace into `phome_ecms_news` values('2','5','0','0','0','0',0x323031372d31322d3139,0x32,'1',0x61646d696e,'0','0','1','0','0','0','0','1513617431','1513621746','1','0','0',0x2c627c,0x2f652f616374696f6e2f53686f77496e666f2e7068703f636c61737369643d352669643d32,'1','1','1',0xe88083e8af95,0xe5908ee79bbee78fade7baa7e591a8e4b880e68a80e69cafe88083e8af95,'1513617367',0x2f642f66696c652f626c6f672f323031372d31322d31392f66366133306332376334396562323062343830663530306332333266613339342e6a7067,'',0xe5908ee79bbee68a8ae88083e8af95e4bd9ce4b8bae4b880e7a78de8a782e5af9fe5ada6e7949fe68a80e69cafe8bf9be6ada5e79a84e8bf87e7a88befbc8ce88083e8af95e79a84e79baee79a84e698afe4b8bae4ba86e4bf83e8bf9be5ada6e7949fe68a80e69cafe79a84e68f90e9ab98efbc8ce58f8ae5a29ee58aa0e88081e5b888e5afb9e5ada6e7949fe5ada6e4b9a0e68385e586b5e4ba86e8a7a3efbc8ce5b9b6e58f8ae697b6e79a84e5afb9e5ada6e7949fe8bf9be8a18ce8be85e5afbce38082,'0');");
E_D("replace into `phome_ecms_news` values('3','5','0','3','0','0',0x323031372d31322d3139,0x33,'1',0x61646d696e,'0','0','1','0','0','0','0','1513617485','1513621756','1','0','0',0x2c627c,0x2f652f616374696f6e2f53686f77496e666f2e7068703f636c61737369643d352669643d33,'1','1','1',0xe5908ee79bbe2ce591a8e4ba942ce8af84e6af94,0xe5908ee79bbee591a8e4ba94e78fade7baa7e4bd9ce4b89ae8af84e6af94,'1513617434',0x2f642f66696c652f626c6f672f323031372d31322d31392f38633632613462383034613139316666333161353962633238626664663965312e6a7067,'',0xe8b68ae58aaae58a9be8b68ae5b9b8e8bf90efbc8ce58f88e588b0e4ba86e5908ee79bbee4b880e591a8e78fade7baa7e5ada6e59198e4bd9ce4b89ae9a1b9e79baee8af84e6af94e79a84e697b6e58099e4ba86efbc8ce681ade5969ce69cace591a8e78fade7baa7e4bd9ce4b89ae9a1b9e79baee69c80e4bc98e7a780e79a84e586a0e5869be5ada6e4b9a0e5b08fe7bb84efbc81,'0');");
E_D("replace into `phome_ecms_news` values('4','5','0','1','0','0',0x323031372d31322d3236,0x34,'1',0x61646d696e,'0','0','1','0','0','0','0','1514276832','1514276832','1','0','0',0x2c627c,0x2f652f616374696f6e2f53686f77496e666f2e7068703f636c61737369643d352669643d34,'1','1','1',0xe5908ee79bbee7bd912ce5bc80e78fad,0xe783ade78388e7a59de8b4bae5908ee79bbee7bd913931e69c9fe5bc80e78fadefbc81,'1514276727',0x2f642f66696c652f626c6f672f323031372d31322d32362f64613131323030396138303566626434363636366238383264646231336438612e6a7067,'',0xe4babae7949fe698afe4b880e4b8aae6b0b8e4b88de5819ce6ad87e79a84e5a594e8b791e69785e7a88be38082e5908ee79bbee7bd91e4b88de4bb85e883bde5b086e4bda0e9a286e585a5e8bf9be4b880e6ada5e6b7b1e980a0e79a84e6a2a6e5af90e4bba5e6b182e79a84e5ada6e5ba9cefbc8ce8bf98e883bde4b8bae4bda0e79599e4b88be4b880e6aeb5e69691e69693e79a84e99d92e698a5e8aeb0e5bf86efbc8ce68890e4b8bae4bda0e5bf83e4b8ade79a84e4b880e4b8aae6988ee5aa9ae8a792e890bde38082e4b88be99da2e8aea9e68891e4bbace794a8e783ade78388e79a84e68e8ce5a3b0e6aca2e8bf8ee5908ee79bbee88081e5b888e4b8bae68891e4bbace887b4e8be9ee38082,'0');");

require("../../inc/footer.php");
?>