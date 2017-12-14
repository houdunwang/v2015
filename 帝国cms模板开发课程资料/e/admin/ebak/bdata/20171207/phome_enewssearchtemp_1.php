<?php
@include("../../inc/header.php");

/*
		SoftName : EmpireBak
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `phome_enewssearchtemp`;");
E_C("CREATE TABLE `phome_enewssearchtemp` (
  `tempid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tempname` varchar(60) NOT NULL DEFAULT '',
  `temptext` mediumtext NOT NULL,
  `subnews` smallint(6) NOT NULL DEFAULT '0',
  `isdefault` tinyint(1) NOT NULL DEFAULT '0',
  `listvar` text NOT NULL,
  `rownum` smallint(6) NOT NULL DEFAULT '0',
  `modid` smallint(6) NOT NULL DEFAULT '0',
  `showdate` varchar(50) NOT NULL DEFAULT '',
  `subtitle` smallint(6) NOT NULL DEFAULT '0',
  `classid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `docode` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tempid`),
  KEY `classid` (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewssearchtemp` values('1','默认搜索模板','<!DOCTYPE html PUBLIC \\\\\"-//W3C//DTD XHTML 1.0 Transitional//EN\\\\\" \\\\\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\\\\\">\r\n<html xmlns=\\\\\"http://www.w3.org/1999/xhtml\\\\\">\r\n<head>\r\n<meta http-equiv=\\\\\"Content-Type\\\\\" content=\\\\\"text/html; charset=utf-8\\\\\" />\r\n<title>[!--keyboard--] 搜索结果 - Powered by EmpireCMS</title>\r\n<link href=\\\\\"[!--news.url--]skin/default/css/style.css\\\\\" rel=\\\\\"stylesheet\\\\\" type=\\\\\"text/css\\\\\" />\r\n<script type=\\\\\"text/javascript\\\\\" src=\\\\\"[!--news.url--]skin/default/js/tabs.js\\\\\"></script>\r\n<style type=\\\\\"text/css\\\\\">\r\n<!--\r\n.r {\r\ndisplay:inline;\r\nfont-weight:normal;\r\nmargin:0;\r\nfont-size:16px;\r\nmargin-top:10px;\r\n}\r\n.a{color:green}\r\n.fl{color:#77c}\r\n-->\r\n</style>\r\n</head>\r\n<body class=\\\\\"listpage\\\\\">\r\n[!--temp.dtheader--]\r\n<table width=\\\\\"100%\\\\\" border=\\\\\"0\\\\\" cellspacing=\\\\\"10\\\\\" cellpadding=\\\\\"0\\\\\">\r\n	<tr valign=\\\\\"top\\\\\">\r\n		<td class=\\\\\"list_content\\\\\"><table width=\\\\\"100%\\\\\" border=\\\\\"0\\\\\" cellspacing=\\\\\"0\\\\\" cellpadding=\\\\\"0\\\\\" class=\\\\\"position\\\\\">\r\n				<tr>\r\n					<td>现在的位置：<a href=\\\\\"[!--news.url--]\\\\\" class=\\\\\"classlinkclass\\\\\">首页</a>&nbsp;>&nbsp;<a href=\\\\\"[!--news.url--]search/\\\\\" class=\\\\\"classlinkclass\\\\\">高级搜索</a>&nbsp;>&nbsp;搜索结果</td>\r\n				</tr>\r\n			</table>\r\n			<table width=\\\\\"100%\\\\\" border=\\\\\"0\\\\\" cellspacing=\\\\\"0\\\\\" cellpadding=\\\\\"0\\\\\" class=\\\\\"box\\\\\">\r\n				<tr>\r\n					<td><form action=\\\\''../../search/index.php\\\\'' method=\\\\\"post\\\\\" name=\\\\\"search_news\\\\\" id=\\\\\"search_news\\\\\">\r\n							<table width=\\\\\"100%\\\\\" border=\\\\\"0\\\\\" cellspacing=\\\\\"6\\\\\" cellpadding=\\\\\"0\\\\\">\r\n								<input type=\\\\\"hidden\\\\\" name=\\\\\"show\\\\\" value=\\\\\"title\\\\\" />\r\n								<tr>\r\n									<td height=\\\\\"32\\\\\">关键字：\r\n										<input name=\\\\\"keyboard\\\\\" type=\\\\\"text\\\\\" id=\\\\\"keyboard\\\\\" value=\\\\\"[!--keyboard--]\\\\\" size=\\\\\"42\\\\\" />\r\n										<input type=\\\\\"submit\\\\\" name=\\\\\"Submit22\\\\\" value=\\\\\"搜索\\\\\" />\r\n										&nbsp;\r\n										<input type=\\\\\"button\\\\\" name=\\\\\"Submit\\\\\" value=\\\\\"高级搜索\\\\\" onclick=\\\\\"self.location.href=\\\\''../../../search/\\\\''\\\\\" />\r\n										(多个关键字请用&quot;空格&quot;隔开) </td>\r\n								</tr>\r\n							</table>\r\n						</form>\r\n						<table width=\\\\\"100%\\\\\" border=\\\\\"0\\\\\" cellpadding=\\\\\"0\\\\\" cellspacing=\\\\\"6\\\\\">\r\n							<tr>\r\n								<td>系统搜索到约有<strong>[!--ecms.num--]</strong>项符合<strong>[!--keyboard--]</strong>的查询结果</td>\r\n							</tr>\r\n						</table>\r\n						[!--empirenews.listtemp--]\r\n						<!--list.var1-->\r\n						[!--empirenews.listtemp--]\r\n						<table width=\\\\\"100%\\\\\" border=\\\\\"0\\\\\" cellspacing=\\\\\"0\\\\\" cellpadding=\\\\\"0\\\\\" class=\\\\\"list_page\\\\\">\r\n							<tr>\r\n								<td>[!--show.page--]</td>\r\n							</tr>\r\n						</table></td>\r\n				</tr>\r\n			</table></td>\r\n	</tr>\r\n</table>\r\n[!--temp.footer--]\r\n</body>\r\n</html>','180','1','<h2 class=\\\\\"r\\\\\"><span>[!--no.num--].</span> <a class=\\\\\"l\\\\\" href=\\\\\"[!--titleurl--]\\\\\" target=\\\\\"_blank\\\\\">[!--title--]</a></h2>\r\n<table width=\\\\\"80%\\\\\" border=\\\\\"0\\\\\" cellpadding=\\\\\"0\\\\\" cellspacing=\\\\\"0\\\\\">\r\n	<tbody>\r\n		<tr>\r\n			<td>[!--smalltext--]</td>\r\n		</tr>\r\n		<tr>\r\n			<td><span class=\\\\\"a\\\\\">[!--titleurl--] - [!--newstime--]</span> - <a class=\\\\\"fl\\\\\" href=\\\\\"[!--this.classlink--]\\\\\" target=\\\\\"_blank\\\\\">[!--this.classname--]</a></td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','1','1','Y-m-d','0','0','0');");

@include("../../inc/footer.php");
?>