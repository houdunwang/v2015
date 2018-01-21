<?php
@include("../../inc/header.php");

/*
		SoftName : EmpireBak
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

E_D("DROP TABLE IF EXISTS `phome_enewstempdt`;");
E_C("CREATE TABLE `phome_enewstempdt` (
  `tempid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `tempvar` char(30) NOT NULL DEFAULT '',
  `tempname` char(30) NOT NULL DEFAULT '',
  `tempsay` char(255) NOT NULL DEFAULT '',
  `tempfile` char(200) NOT NULL DEFAULT '',
  `myorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `temptype` char(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`tempid`),
  UNIQUE KEY `tempvar` (`tempvar`),
  KEY `temptype` (`temptype`),
  KEY `myorder` (`myorder`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8");
E_D("replace into `phome_enewstempdt` values('1','header','主界面头部','主界面头部','e/template/incfile/header.php','0','incfile');");
E_D("replace into `phome_enewstempdt` values('2','footer','主界面尾部','主界面尾部','e/template/incfile/footer.php','0','incfile');");
E_D("replace into `phome_enewstempdt` values('3','qDoInfo','管理投稿首页','管理投稿首页','e/template/DoInfo/DoInfo.php','0','doinfo');");
E_D("replace into `phome_enewstempdt` values('4','qChangeClass','投稿选择栏目页','投稿选择栏目页','e/template/DoInfo/ChangeClass.php','0','doinfo');");
E_D("replace into `phome_enewstempdt` values('5','qDoInfoTran','发布投稿上传附件页面','发布投稿上传附件页面','e/template/DoInfo/tran.php','0','doinfo');");
E_D("replace into `phome_enewstempdt` values('6','qAddInfo','发布投稿页','发布投稿页','e/template/DoInfo/AddInfo.php','0','doinfo');");
E_D("replace into `phome_enewstempdt` values('7','qListInfo','默认管理投稿列表页','默认管理投稿列表页','e/data/html/list/qlistinfo.php','0','doinfo');");
E_D("replace into `phome_enewstempdt` values('8','report','提交错误报告页面','提交错误报告页面','e/template/public/report.php','0','pubtemp');");
E_D("replace into `phome_enewstempdt` values('9','payapi','在线支付页面','在线支付页面','e/template/payapi/payapi.php','0','pubtemp');");
E_D("replace into `phome_enewstempdt` values('10','infovote','信息投票页面','信息投票页面','e/template/public/vote.php','0','pubtemp');");
E_D("replace into `phome_enewstempdt` values('11','vote','投票插件页面','投票插件页面','e/template/tool/vote.php','0','pubtemp');");
E_D("replace into `phome_enewstempdt` values('12','ShopBurcar','购物车页面','购物车页面','e/template/ShopSys/buycar.php','0','shopsys');");
E_D("replace into `phome_enewstempdt` values('13','ShopOrder','提交订单页面','提交订单页面','e/template/ShopSys/order.php','0','shopsys');");
E_D("replace into `phome_enewstempdt` values('14','ShopSubmitOrder','确认提交订单页面','确认提交订单页面','e/template/ShopSys/SubmitOrder.php','0','shopsys');");
E_D("replace into `phome_enewstempdt` values('15','ShopListDd','订单列表页面','订单列表页面','e/template/ShopSys/ListDd.php','0','shopsys');");
E_D("replace into `phome_enewstempdt` values('16','ShopShowDd','订单详细页面','订单详细页面','e/template/ShopSys/ShowDd.php','0','shopsys');");
E_D("replace into `phome_enewstempdt` values('17','ShopBurcarForm','购物车-加入表单模板','购物车-加入表单模板','e/template/ShopSys/buycar/buycar_form.php','0','shopsys');");
E_D("replace into `phome_enewstempdt` values('18','ShopBurcarOrder','购物车-确认订单模板','购物车-确认订单模板','e/template/ShopSys/buycar/buycar_order.php','0','shopsys');");
E_D("replace into `phome_enewstempdt` values('19','ShopBurcarShowdd','购物车-显示订单模板','购物车-显示订单模板','e/template/ShopSys/buycar/buycar_showdd.php','0','shopsys');");
E_D("replace into `phome_enewstempdt` values('20','ShopAddAddress','增加配送地址页面','增加配送地址页面','e/template/ShopSys/AddAddress.php','0','shopsys');");
E_D("replace into `phome_enewstempdt` values('21','ShopListAddress','管理配送地址页面','管理配送地址页面','e/template/ShopSys/ListAddress.php','0','shopsys');");
E_D("replace into `phome_enewstempdt` values('22','MemberReg','会员注册页面','会员注册页面','e/template/member/register.php','0','member');");
E_D("replace into `phome_enewstempdt` values('23','MemberChangeReg','选择注册类型页面','选择注册类型页面','e/template/member/ChangeRegister.php','0','member');");
E_D("replace into `phome_enewstempdt` values('24','MemberRegsend','重发注册激活邮件页面','重发注册激活邮件页面','e/template/member/regsend.php','0','member');");
E_D("replace into `phome_enewstempdt` values('25','MemberLogin','会员登录页面','会员登录页面','e/template/member/login.php','0','member');");
E_D("replace into `phome_enewstempdt` values('26','MemberLoginopen','会员登录弹出页面','会员登录弹出页面','e/template/member/loginopen.php','0','member');");
E_D("replace into `phome_enewstempdt` values('27','MemberEditinfo','修改会员信息页面','修改会员信息页面','e/template/member/EditInfo.php','0','member');");
E_D("replace into `phome_enewstempdt` values('28','MemberEditsafeinfo','修改会员安全信息页面','修改会员安全信息页面','e/template/member/EditSafeInfo.php','0','member');");
E_D("replace into `phome_enewstempdt` values('29','MemberGetPassword','取回密码页面','取回密码页面','e/template/member/GetPassword.php','0','member');");
E_D("replace into `phome_enewstempdt` values('30','MemberGetResetPass','取回密码重置页面','取回密码重置页面','e/template/member/getpass.php','0','member');");
E_D("replace into `phome_enewstempdt` values('31','MemberCp','会员中心首页','会员中心首页','e/template/member/cp.php','0','member');");
E_D("replace into `phome_enewstempdt` values('32','MemberMy','会员状态页面','会员状态页面','e/template/member/my.php','0','member');");
E_D("replace into `phome_enewstempdt` values('33','MemberShowInfo','查看会员信息页面','查看会员信息页面','e/template/member/ShowInfo.php','0','member');");
E_D("replace into `phome_enewstempdt` values('34','MemberList1','默认会员列表页面','默认会员列表页面','e/template/member/memberlist/1.php','0','member');");
E_D("replace into `phome_enewstempdt` values('35','MemberAddMsg','发送站内消息页面','发送站内消息页面','e/template/member/AddMsg.php','0','membermsg');");
E_D("replace into `phome_enewstempdt` values('36','MemberMsg','站内消息列表页面','站内消息列表页面','e/template/member/msg.php','0','membermsg');");
E_D("replace into `phome_enewstempdt` values('37','MemberViewMsg','查看站内消息页面','查看站内消息页面','e/template/member/ViewMsg.php','0','membermsg');");
E_D("replace into `phome_enewstempdt` values('38','MemberAddFriend','增加好友页面','增加好友页面','e/template/member/AddFriend.php','0','memberfriend');");
E_D("replace into `phome_enewstempdt` values('39','MemberFriend','好友列表页面','好友列表页面','e/template/member/friend.php','0','memberfriend');");
E_D("replace into `phome_enewstempdt` values('40','MemberFriendClass','好友分类页面','好友分类页面','e/template/member/FriendClass.php','0','memberfriend');");
E_D("replace into `phome_enewstempdt` values('41','MemberChangeFriend','选择好友页面','选择好友页面','e/template/member/ChangeFriend.php','0','memberfriend');");
E_D("replace into `phome_enewstempdt` values('42','MemberAddFava','增加收藏信息页面','增加收藏信息页面','e/template/member/AddFava.php','0','memberfav');");
E_D("replace into `phome_enewstempdt` values('43','MemberFava','管理收藏页面','管理收藏页面','e/template/member/fava.php','0','memberfav');");
E_D("replace into `phome_enewstempdt` values('44','MemberFavaClass','管理收藏分类页面','管理收藏分类页面','e/template/member/FavaClass.php','0','memberfav');");
E_D("replace into `phome_enewstempdt` values('45','MemberBuybak','充值记录页面','充值记录页面','e/template/member/buybak.php','0','memberother');");
E_D("replace into `phome_enewstempdt` values('46','MemberDownbak','下载记录页面','下载记录页面','e/template/member/downbak.php','0','memberother');");
E_D("replace into `phome_enewstempdt` values('47','MemberBuygroup','购买会员类型页面','购买会员类型页面','e/template/member/buygroup.php','0','memberother');");
E_D("replace into `phome_enewstempdt` values('48','MemberCard','点卡充值页面','点卡充值页面','e/template/member/card.php','0','memberother');");
E_D("replace into `phome_enewstempdt` values('49','MemberChangeStyle','选择会员空间风格页面','选择会员空间风格页面','e/template/member/mspace/ChangeStyle.php','0','memberspace');");
E_D("replace into `phome_enewstempdt` values('50','MemberSetSpace','设置会员空间页面','设置会员空间页面','e/template/member/mspace/SetSpace.php','0','memberspace');");
E_D("replace into `phome_enewstempdt` values('51','MemberFeedback','管理会员空间反馈页面','管理会员空间反馈页面','e/template/member/mspace/feedback.php','0','memberspace');");
E_D("replace into `phome_enewstempdt` values('52','MemberShowFeedback','查看会员空间反馈页面','查看会员空间反馈页面','e/template/member/mspace/ShowFeedback.php','0','memberspace');");
E_D("replace into `phome_enewstempdt` values('53','MemberGbook','管理会员空间留言页面','管理会员空间留言页面','e/template/member/mspace/gbook.php','0','memberspace');");
E_D("replace into `phome_enewstempdt` values('54','MemberReGbook','回复会员空间留言页面','回复会员空间留言页面','e/template/member/mspace/ReGbook.php','0','memberspace');");
E_D("replace into `phome_enewstempdt` values('55','MemberConnectListBind','登录绑定管理页面','登录绑定管理页面','e/template/memberconnect/ListBind.php','0','memberconnect');");
E_D("replace into `phome_enewstempdt` values('56','MemberConnectTobind','绑定登录帐号页面','绑定登录帐号页面','e/template/memberconnect/tobind.php','0','memberconnect');");

@include("../../inc/footer.php");
?>