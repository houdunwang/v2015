DROP TABLE IF EXISTS `phpcms_comment_table`;
CREATE TABLE IF NOT EXISTS `phpcms_comment_table` (
  `tableid` mediumint(8) NOT NULL auto_increment COMMENT '表ID号',
  `total` int(10) unsigned default '0' COMMENT '数据总量',
  `creat_at` int(10) default '0' COMMENT '创建时间',
  PRIMARY KEY  (`tableid`)
) TYPE=MyISAM;
INSERT INTO `phpcms_comment_table` (`tableid`, `total`, `creat_at`) VALUES (1, 0, 0);
