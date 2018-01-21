<?php
if(!defined('InEmpireCMS'))
{
	exit();
}

//------- 建立数据表 -------

//公共表
$tablename=$dbtbpre."ecms_".$tbname."_index";
$sqlindex=$empire->query(SetCreateTable("CREATE TABLE `".$tablename."` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `classid` smallint(5) unsigned NOT NULL default '0',
  `checked` tinyint(1) NOT NULL default '0',
  `newstime` int(10) unsigned NOT NULL default '0',
  `truetime` int(10) unsigned NOT NULL default '0',
  `lastdotime` int(10) unsigned NOT NULL default '0',
  `havehtml` tinyint(1) NOT NULL default '0',
  PRIMARY KEY (`id`),
  KEY `classid` (`classid`),
  KEY `checked` (`checked`),
  KEY `newstime` (`newstime`),
  KEY `truetime` (`truetime`,`id`),
  KEY `havehtml` (`classid`,`truetime`,`havehtml`,`checked`,`id`)
  ) TYPE=MyISAM;",$ecms_config['db']['dbchar']));

//主表
$tablename=$dbtbpre."ecms_".$tbname;
$sql=$empire->query(SetCreateTable("CREATE TABLE `".$tablename."` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `classid` smallint(5) unsigned NOT NULL default '0',
  `ttid` smallint(5) unsigned NOT NULL default '0',
  `onclick` int(10) unsigned NOT NULL default '0',
  `plnum` mediumint(8) unsigned NOT NULL default '0',
  `totaldown` mediumint(8) unsigned NOT NULL default '0',
  `newspath` char(20) NOT NULL default '',
  `filename` char(36) NOT NULL default '',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL default '',
  `firsttitle` tinyint(1) NOT NULL default '0',
  `isgood` tinyint(1) NOT NULL default '0',
  `ispic` tinyint(1) NOT NULL default '0',
  `istop` tinyint(1) NOT NULL default '0',
  `isqf` tinyint(1) NOT NULL default '0',
  `ismember` tinyint(1) NOT NULL default '0',
  `isurl` tinyint(1) NOT NULL default '0',
  `truetime` int(10) unsigned NOT NULL default '0',
  `lastdotime` int(10) unsigned NOT NULL default '0',
  `havehtml` tinyint(1) NOT NULL default '0',
  `groupid` smallint(5) unsigned NOT NULL default '0',
  `userfen` smallint(5) unsigned NOT NULL default '0',
  `titlefont` char(14) NOT NULL default '',
  `titleurl` char(200) NOT NULL default '',
  `stb` tinyint(3) unsigned NOT NULL default '1',
  `fstb` tinyint(3) unsigned NOT NULL default '1',
  `restb` tinyint(3) unsigned NOT NULL default '1',
  `keyboard` char(80) NOT NULL default '',
  `title` char(100) NOT NULL default '',
  `newstime` int(10) unsigned NOT NULL default '0',
  `titlepic` char(120) NOT NULL default '',
  PRIMARY KEY (`id`),
  KEY `classid` (`classid`),
  KEY `newstime` (`newstime`),
  KEY `ttid` (`ttid`),
  KEY `firsttitle` (`firsttitle`),
  KEY `isgood` (`isgood`),
  KEY `ispic` (`ispic`),
  KEY `useridis` (`userid`,`ismember`)
  ) TYPE=MyISAM;",$ecms_config['db']['dbchar']));

//副表
$tablename=$dbtbpre."ecms_".$tbname."_data_1";
$sqldata=$empire->query(SetCreateTable("CREATE TABLE `".$tablename."` (
  `id` int(10) unsigned NOT NULL default '0',
  `classid` smallint(5) unsigned NOT NULL default '0',
  `keyid` char(255) NOT NULL default '',
  `dokey` tinyint(1) NOT NULL default '0',
  `newstempid` smallint(5) unsigned NOT NULL default '0',
  `closepl` tinyint(1) NOT NULL default '0',
  `haveaddfen` tinyint(1) NOT NULL default '0',
  `infotags` char(80) NOT NULL default '',
  PRIMARY KEY (`id`),
  KEY `classid` (`classid`)
  ) TYPE=MyISAM;",$ecms_config['db']['dbchar']));

//采集节点附加表
$tablename=$dbtbpre."ecms_infoclass_".$tbname;
$infoclass=$empire->query(SetCreateTable("CREATE TABLE `".$tablename."` (
  `classid` int(10) unsigned not null default '0',
  `zz_title` text NOT NULL,
  `z_title` varchar(255) NOT NULL default '',
  `qz_title` varchar(255) NOT NULL default '',
  `save_title` varchar(10) NOT NULL default '',
  `zz_titlepic` text NOT NULL,
  `z_titlepic` varchar(255) NOT NULL default '',
  `qz_titlepic` varchar(255) NOT NULL default '',
  `save_titlepic` varchar(10) NOT NULL default '',
  `zz_newstime` text NOT NULL,
  `z_newstime` varchar(255) NOT NULL default '',
  `qz_newstime` varchar(255) NOT NULL default '',
  `save_newstime` varchar(10) NOT NULL default '',
  PRIMARY KEY (`classid`)
  ) TYPE=MyISAM;",$ecms_config['db']['dbchar']));

//采集数据临时表
$tablename=$dbtbpre."ecms_infotmp_".$tbname;
$infotmp=$empire->query(SetCreateTable("CREATE TABLE `".$tablename."` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `classid` int(10) unsigned NOT NULL default '0',
  `oldurl` char(200) NOT NULL default '',
  `checked` tinyint(1) NOT NULL default '0',
  `tmptime` datetime NOT NULL default '0000-00-00 00:00:00',
  `userid` mediumint(8) unsigned NOT NULL default '0',
  `username` char(20) NOT NULL default '',
  `truetime` int(10) unsigned NOT NULL default '0',
  `keyboard` char(100) NOT NULL default '',
  `title` char(100) NOT NULL default '',
  `newstime` datetime NOT NULL default '0000-00-00 00:00:00',
  `titlepic` char(120) NOT NULL default '',
  PRIMARY KEY (`id`),
  KEY `classid` (`classid`),
  KEY `checked` (`checked`)
  ) TYPE=MyISAM;",$ecms_config['db']['dbchar']));

//字段表数据
$sysfdata=ReadFiletext('../data/html/sysfhtml.txt');
$sys_selectf='fid,f,fname,fform,fhtml,fzs,isadd,isshow,iscj,cjhtml,myorder,ftype,flen,dotemp,tid,tbname,savetxt,fvalue,iskey,tobr,dohtml,qfhtml,isonly,linkfieldval,samedata,fformsize,tbdataf,ispage,adddofun,editdofun,qadddofun,qeditdofun,linkfieldtb,linkfieldshow,editorys,issmalltext';

$sysf_titler=explode('[!--sys.title--]',$sysfdata);
$sysf_titletr=explode('[!--sys.qf.exp--]',$sysf_titler[1]);
$empire->query("insert into `{$dbtbpre}enewsf`($sys_selectf) values(NULL,'title','标题','text','".addslashes($sysf_titletr[0])."','标题','0','1','1','".addslashes($sysf_titletr[2])."','0','CHAR','100','1','$tid','$tbname','0','','0','0','0','".addslashes($sysf_titletr[1])."','0','','0','60','0','0','','','','','','','0','0');");

$sysf_specialr=explode('[!--sys.special.field--]',$sysfdata);
$sysf_specialtr=explode('[!--sys.qf.exp--]',$sysf_specialr[1]);
$empire->query("insert into `{$dbtbpre}enewsf`($sys_selectf) values(NULL,'special.field','特殊属性','','".addslashes($sysf_specialtr[0])."','特殊属性','0','1','0','".addslashes($sysf_specialtr[2])."','0','','0','0','$tid','$tbname','0','','0','0','0','".addslashes($sysf_specialtr[1])."','0','','0','','0','0','','','','','','','0','0');");

$sysf_titlepicr=explode('[!--sys.titlepic--]',$sysfdata);
$sysf_titlepictr=explode('[!--sys.qf.exp--]',$sysf_titlepicr[1]);
$empire->query("insert into `{$dbtbpre}enewsf`($sys_selectf) values(NULL,'titlepic','标题图片','img','".addslashes($sysf_titlepictr[0])."','标题图片','0','1','1','".addslashes($sysf_titlepictr[2])."','0','CHAR','120','1','$tid','$tbname','0','','0','0','0','".addslashes($sysf_titlepictr[1])."','0','','0','60','0','0','','','','','','','0','0');");

$sysf_newstimer=explode('[!--sys.newstime--]',$sysfdata);
$sysf_newstimetr=explode('[!--sys.qf.exp--]',$sysf_newstimer[1]);
$empire->query("insert into `{$dbtbpre}enewsf`($sys_selectf) values(NULL,'newstime','发布时间','text','".addslashes($sysf_newstimetr[0])."','发布时间','0','1','1','".addslashes($sysf_newstimetr[2])."','0','INT','11','1','$tid','$tbname','0','','1','0','0','".addslashes($sysf_newstimetr[1])."','0','','0','','0','0','','','','','','','0','0');");

?>