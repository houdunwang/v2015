DROP TABLE IF EXISTS `phpcms_comment_check`;
CREATE TABLE IF NOT EXISTS `phpcms_comment_check` (
  `id` int(10) NOT NULL auto_increment,
  `comment_data_id` int(10) default '0' COMMENT '论评ID号',
  `siteid` smallint(5) NOT NULL default '0' COMMENT '站点ID',
  `tableid` mediumint(8) default '0' COMMENT '数据存储表ID',
  PRIMARY KEY  (`id`),
  KEY `siteid` (`siteid`),
  KEY `comment_data_id` (`comment_data_id`)
) TYPE=MyISAM;
