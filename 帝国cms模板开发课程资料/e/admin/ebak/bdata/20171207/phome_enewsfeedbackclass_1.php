<?php
@include("../../inc/header.php");

/*
		SoftName : EmpireBak
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `phome_enewsfeedbackclass`;");
E_C("CREATE TABLE `phome_enewsfeedbackclass` (
  `bid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `bname` varchar(60) NOT NULL DEFAULT '',
  `btemp` mediumtext NOT NULL,
  `bzs` varchar(255) NOT NULL DEFAULT '',
  `enter` text NOT NULL,
  `mustenter` text NOT NULL,
  `filef` varchar(255) NOT NULL DEFAULT '',
  `groupid` smallint(6) NOT NULL DEFAULT '0',
  `checkboxf` text NOT NULL,
  `usernames` text NOT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsfeedbackclass` values('1','默认反馈分类','[!--cp.header--]\r\n<table width=100% align=center cellpadding=3 cellspacing=1 class=\\\\\"tableborder\\\\\">\r\n  <form name=\\\\''feedback\\\\'' method=\\\\''post\\\\'' enctype=\\\\''multipart/form-data\\\\'' action=\\\\''../../enews/index.php\\\\''>\r\n    <input name=\\\\''enews\\\\'' type=\\\\''hidden\\\\'' value=\\\\''AddFeedback\\\\''>\r\n    <tr>\r\n      <td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''><div align=\\\\\"right\\\\\">您的姓名:</div></td>\r\n      <td bgcolor=\\\\''ffffff\\\\''><input name=\\\\''name\\\\'' type=\\\\''text\\\\'' size=\\\\''42\\\\''>\r\n        (*)</td>\r\n    </tr>\r\n    <tr>\r\n      <td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''><div align=\\\\\"right\\\\\">职务:</div></td>\r\n      <td bgcolor=\\\\''ffffff\\\\''><input name=\\\\''job\\\\'' type=\\\\''text\\\\'' size=\\\\''42\\\\''></td>\r\n    </tr>\r\n    <tr>\r\n      <td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''><div align=\\\\\"right\\\\\">公司名称:</div></td>\r\n      <td bgcolor=\\\\''ffffff\\\\''><input name=\\\\''company\\\\'' type=\\\\''text\\\\'' size=\\\\''42\\\\''></td>\r\n    </tr>\r\n    <tr>\r\n      <td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''><div align=\\\\\"right\\\\\">联系邮箱:</div></td>\r\n      <td bgcolor=\\\\''ffffff\\\\''><input name=\\\\''email\\\\'' type=\\\\''text\\\\'' size=\\\\''42\\\\''></td>\r\n    </tr>\r\n    <tr>\r\n      <td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''><div align=\\\\\"right\\\\\">联系电话:</div></td>\r\n      <td bgcolor=\\\\''ffffff\\\\''><input name=\\\\''mycall\\\\'' type=\\\\''text\\\\'' size=\\\\''42\\\\''>\r\n        (*)</td>\r\n    </tr>\r\n    <tr>\r\n      <td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''><div align=\\\\\"right\\\\\">网站:</div></td>\r\n      <td bgcolor=\\\\''ffffff\\\\''><input name=\\\\''homepage\\\\'' type=\\\\''text\\\\'' size=\\\\''42\\\\''></td>\r\n    </tr>\r\n    <tr>\r\n      <td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''><div align=\\\\\"right\\\\\">联系地址:</div></td>\r\n      <td bgcolor=\\\\''ffffff\\\\''><input name=\\\\''address\\\\'' type=\\\\''text\\\\'' size=\\\\\"42\\\\\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''><div align=\\\\\"right\\\\\">信息标题:</div></td>\r\n      <td bgcolor=\\\\''ffffff\\\\''><input name=\\\\''title\\\\'' type=\\\\''text\\\\'' size=\\\\\"42\\\\\"> (*)</td>\r\n    </tr>\r\n    <tr> \r\n      <td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''><div align=\\\\\"right\\\\\">信息内容(*):</div></td>\r\n      <td bgcolor=\\\\''ffffff\\\\''><textarea name=\\\\''saytext\\\\'' cols=\\\\''60\\\\'' rows=\\\\''12\\\\''></textarea> \r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td bgcolor=\\\\''ffffff\\\\''></td>\r\n      <td bgcolor=\\\\''ffffff\\\\''><input type=\\\\''submit\\\\'' name=\\\\''submit\\\\'' value=\\\\''提交\\\\''></td>\r\n    </tr>\r\n  </form>\r\n</table>\r\n[!--cp.footer--]','','您的姓名<!--field--->name<!--record-->职务<!--field--->job<!--record-->公司名称<!--field--->company<!--record-->联系邮箱<!--field--->email<!--record-->联系电话<!--field--->mycall<!--record-->网站<!--field--->homepage<!--record-->联系地址<!--field--->address<!--record-->信息标题<!--field--->title<!--record-->信息内容<!--field--->saytext<!--record-->',',name,mycall,title,saytext,',',','0','','');");

@include("../../inc/footer.php");
?>