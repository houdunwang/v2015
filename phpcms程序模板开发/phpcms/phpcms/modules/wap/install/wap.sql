DROP TABLE IF EXISTS `phpcms_wap`;
CREATE TABLE IF NOT EXISTS `phpcms_wap` (
  `siteid` smallint(5) unsigned NOT NULL DEFAULT '1',
  `sitename` char(30) NOT NULL,
  `logo` char(100) DEFAULT NULL,
  `domain` varchar(100) DEFAULT NULL,
  `setting` mediumtext,
  `status` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`siteid`)
) TYPE=MyISAM;

DROP TABLE IF EXISTS `phpcms_wap_type`;
CREATE TABLE IF NOT EXISTS `phpcms_wap_type` (
  `typeid` smallint(5) NOT NULL AUTO_INCREMENT,
  `cat` smallint(5) NOT NULL,
  `parentid` smallint(5) NOT NULL,
  `typename` varchar(30) NOT NULL,
  `siteid` smallint(5) NOT NULL,
  `listorder` smallint(5) DEFAULT '0',
  PRIMARY KEY (`typeid`)
) TYPE=MyISAM;

INSERT INTO `phpcms_wap` (`siteid`, `sitename`, `logo`, `domain`, `setting`, `status`) VALUES(1, 'PHPCMS手机门户', '/statics/images/wap/wlogo.gif', '', 'array (\n  ''listnum'' => ''10'',\n  ''thumb_w'' => ''220'',\n  ''thumb_h'' => ''0'',\n  ''c_num'' => ''1000'',\n  ''index_template'' => ''index'',\n  ''category_template'' => ''category'',\n  ''list_template'' => ''list'',\n  ''show_template'' => ''show'',\n)', 0);
