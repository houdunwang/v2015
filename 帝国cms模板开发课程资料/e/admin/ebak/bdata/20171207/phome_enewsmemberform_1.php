<?php
@include("../../inc/header.php");

/*
		SoftName : EmpireBak
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `phome_enewsmemberform`;");
E_C("CREATE TABLE `phome_enewsmemberform` (
  `fid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(60) NOT NULL DEFAULT '',
  `ftemp` mediumtext NOT NULL,
  `fzs` varchar(255) NOT NULL DEFAULT '',
  `enter` text NOT NULL,
  `mustenter` text NOT NULL,
  `filef` varchar(255) NOT NULL DEFAULT '',
  `imgf` varchar(255) NOT NULL DEFAULT '0',
  `tobrf` text NOT NULL,
  `viewenter` text NOT NULL,
  `searchvar` varchar(255) NOT NULL DEFAULT '',
  `canaddf` text NOT NULL,
  `caneditf` text NOT NULL,
  `checkboxf` text NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewsmemberform` values('1','个人注册表单','<table width=\\\\''100%\\\\'' align=\\\\''center\\\\'' cellpadding=3 cellspacing=1 bgcolor=\\\\''#DBEAF5\\\\''>\r\n<tr><td width=\\\\''25%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>真实姓名</td><td bgcolor=\\\\''ffffff\\\\''>[!--truename--]</td></tr>\r\n<tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>QQ号码</td><td bgcolor=\\\\''ffffff\\\\''>[!--oicq--]</td></tr>\r\n<tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>MSN</td><td bgcolor=\\\\''ffffff\\\\''>[!--msn--]</td></tr>\r\n<tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>联系电话</td><td bgcolor=\\\\''ffffff\\\\''>[!--mycall--]</td></tr>\r\n<tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>手机</td><td bgcolor=\\\\''ffffff\\\\''>[!--phone--]</td></tr>\r\n<tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>网站地址</td><td bgcolor=\\\\''ffffff\\\\''>[!--homepage--]</td></tr>\r\n<tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>会员头像</td><td bgcolor=\\\\''ffffff\\\\''>[!--userpic--]</td></tr>\r\n<tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>联系地址</td><td bgcolor=\\\\''ffffff\\\\''>[!--address--]&nbsp;邮编: [!--zip--]</td></tr>\r\n<tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>个人介绍</td><td bgcolor=\\\\''ffffff\\\\''>[!--saytext--]</td></tr>\r\n</table>','','真实姓名<!--field--->truename<!--record-->联系电话<!--field--->mycall<!--record-->手机<!--field--->phone<!--record-->QQ号码<!--field--->oicq<!--record-->MSN<!--field--->msn<!--record-->网站地址<!--field--->homepage<!--record-->会员头像<!--field--->userpic<!--record-->联系地址<!--field--->address<!--record-->邮编<!--field--->zip<!--record-->简介<!--field--->saytext<!--record-->','',',',',userpic,',',saytext,','真实姓名<!--field--->truename<!--record-->联系电话<!--field--->mycall<!--record-->手机<!--field--->phone<!--record-->QQ号码<!--field--->oicq<!--record-->MSN<!--field--->msn<!--record-->网站地址<!--field--->homepage<!--record-->会员头像<!--field--->userpic<!--record-->联系地址<!--field--->address<!--record-->邮编<!--field--->zip<!--record-->简介<!--field--->saytext<!--record-->','',',truename,mycall,phone,oicq,msn,homepage,userpic,address,zip,saytext,',',truename,mycall,phone,oicq,msn,homepage,userpic,address,zip,saytext,',',');");
E_D("replace into `phome_enewsmemberform` values('2','企员注册表单','<table width=\\\\''100%\\\\'' align=\\\\''center\\\\'' cellpadding=3 cellspacing=1 bgcolor=\\\\''#DBEAF5\\\\''><tr><td width=\\\\''25%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>公司名称</td><td bgcolor=\\\\''ffffff\\\\''>[!--company--](*)</td></tr><tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>联系人</td><td bgcolor=\\\\''ffffff\\\\''>[!--truename--](*)</td></tr><tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>联系电话</td><td bgcolor=\\\\''ffffff\\\\''>[!--mycall--](*)</td></tr><tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>传真</td><td bgcolor=\\\\''ffffff\\\\''>[!--fax--]</td></tr><tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>手机</td><td bgcolor=\\\\''ffffff\\\\''>[!--phone--]</td></tr><tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>QQ号码</td><td bgcolor=\\\\''ffffff\\\\''>[!--oicq--]</td></tr><tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>MSN</td><td bgcolor=\\\\''ffffff\\\\''>[!--msn--]</td></tr><tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>网址</td><td bgcolor=\\\\''ffffff\\\\''>[!--homepage--]</td></tr>\r\n<tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>会员头像</td><td bgcolor=\\\\''ffffff\\\\''>[!--userpic--]</td></tr>\r\n<tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>联系地址</td><td bgcolor=\\\\''ffffff\\\\''>[!--address--]&nbsp;邮编: [!--zip--]</td></tr><tr><td width=\\\\''16%\\\\'' height=25 bgcolor=\\\\''ffffff\\\\''>公司介绍</td><td bgcolor=\\\\''ffffff\\\\''>[!--saytext--]</td></tr></table>','','公司名称<!--field--->company<!--record-->联系人<!--field--->truename<!--record-->联系电话<!--field--->mycall<!--record-->传真<!--field--->fax<!--record-->手机<!--field--->phone<!--record-->QQ号码<!--field--->oicq<!--record-->MSN<!--field--->msn<!--record-->网址<!--field--->homepage<!--record-->会员头像<!--field--->userpic<!--record-->联系地址<!--field--->address<!--record-->邮编<!--field--->zip<!--record-->公司介绍<!--field--->saytext<!--record-->',',company,truename,mycall,',',',',userpic,',',saytext,','公司名称<!--field--->company<!--record-->联系人<!--field--->truename<!--record-->联系电话<!--field--->mycall<!--record-->传真<!--field--->fax<!--record-->手机<!--field--->phone<!--record-->QQ号码<!--field--->oicq<!--record-->MSN<!--field--->msn<!--record-->网址<!--field--->homepage<!--record-->会员头像<!--field--->userpic<!--record-->联系地址<!--field--->address<!--record-->邮编<!--field--->zip<!--record-->公司介绍<!--field--->saytext<!--record-->',',company,',',company,truename,mycall,fax,phone,oicq,msn,homepage,userpic,address,zip,saytext,',',company,truename,mycall,fax,phone,oicq,msn,homepage,userpic,address,zip,saytext,',',');");

@include("../../inc/footer.php");
?>