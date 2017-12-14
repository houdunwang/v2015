<?php
@include("../../inc/header.php");

/*
		SoftName : EmpireBak
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `phome_enewsprinttemp`;");
E_C("CREATE TABLE `phome_enewsprinttemp` (
  `tempid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tempname` varchar(60) NOT NULL DEFAULT '',
  `temptext` mediumtext NOT NULL,
  `isdefault` tinyint(1) NOT NULL DEFAULT '0',
  `showdate` varchar(50) NOT NULL DEFAULT '',
  `modid` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tempid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsprinttemp` values('1','默认打印模板','<html>\r\n<head>\r\n<meta http-equiv=\\\\\"content-type\\\\\" content=\\\\\"text/html; charset=utf-8\\\\\">\r\n<title>[!--pagetitle--] - Powered by EmpireCMS</title>\r\n<meta name=\\\\\"keywords\\\\\" content=\\\\\"[!--pagekey--]\\\\\" />\r\n<meta name=\\\\\"description\\\\\" content=\\\\\"[!--pagedes--]\\\\\" />\r\n<style>\r\nbody{font-family:宋体}td,.f12{font-size:12px}.f24 {font-size:24px;}.f14 {font-size:14px;}.title14 {font-size:14px;line-height:130%}.l17 {line-height:170%;}\r\n</style>\r\n</head>\r\n<body bgcolor=\\\\\"#ffffff\\\\\" topmargin=5 leftmargin=5 marginheight=5 marginwidth=5 onLoad=\\\\''window.print()\\\\''>\r\n<center>\r\n<table width=650 border=0 cellspacing=0 cellpadding=0>\r\n<tr>\r\n<td height=65 width=180><A href=\\\\\"http://www.phome.net/\\\\\"><IMG src=\\\\\"../../skin/default/images/elogo.jpg\\\\\" alt=\\\\\"帝国软件\\\\\" width=\\\\\"180\\\\\" height=\\\\\"65\\\\\" border=0></A></td> \r\n<td valign=\\\\\"bottom\\\\\">[!--url--]</td>\r\n<td width=\\\\\"83\\\\\" align=\\\\\"right\\\\\" valign=\\\\\"bottom\\\\\"><a href=\\\\''javascript:history.back()\\\\''>返回</a>　<a href=\\\\''javascript:window.print()\\\\''>打印</a></td>\r\n</tr>\r\n</table>\r\n<table width=650 border=0 cellpadding=0 cellspacing=20 bgcolor=\\\\\"#EDF0F5\\\\\">\r\n<tr>\r\n<td>\r\n<BR>\r\n<TABLE cellSpacing=0 cellPadding=0 width=\\\\\"100%\\\\\" border=0>\r\n<TBODY>\r\n<TR>\r\n<TH class=\\\\\"f24\\\\\"><FONT color=#05006c>[!--title--]</FONT></TH></TR>\r\n<TR>\r\n<TD>\r\n<HR SIZE=1 bgcolor=\\\\\"#d9d9d9\\\\\">\r\n</TD>\r\n</TR>\r\n<TR>\r\n<TD align=\\\\\"middle\\\\\" height=20><div align=\\\\\"center\\\\\">[!--writer--]&nbsp;&nbsp;[!--newstime--]&nbsp;&nbsp;[!--befrom--]</div></TD>\r\n</TR>\r\n<TR>\r\n<TD height=15></TD>\r\n</TR>\r\n<TR>\r\n<TD class=\\\\\"l17\\\\\">\r\n<FONT class=\\\\\"f14\\\\\" id=\\\\\"zoom\\\\\"> \r\n<P>[!--newstext--]<br>\r\n<BR clear=all>\r\n</P>\r\n</FONT>\r\n</TD>\r\n</TR>\r\n<TR height=10>\r\n<TD></TD>\r\n</TR>\r\n</TBODY>\r\n</TABLE>\r\n[!--titlelink--]\r\n</td>\r\n</tr>\r\n</table>\r\n</center>\r\n</body>\r\n</html>','1','Y-m-d H:i:s','1');");

@include("../../inc/footer.php");
?>