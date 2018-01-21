<?php namespace system\database\seeds;

use houdunwang\database\build\Seeder;
use houdunwang\db\Db;

class hd170602112255_menu extends Seeder
{
    //执行
    public function up()
    {
        if (Db::table('menu')->find(1)) {
            return;
        }
        $sql
            = <<<str
INSERT INTO `hd_menu` (`id`, `pid`, `title`, `permission`, `url`, `append_url`, `icon`, `orderby`, `is_display`, `is_system`, `mark`)
VALUES
	(1,0,'微信功能','','?s=site/entry/home','','fa fa-comments-o',0,1,1,'platform'),
	(2,1,'基本功能','','','','',0,1,1,'platform'),
	(3,2,'文字回复','platform_reply_basic','?s=site/rule/lists&m=basic','?s=site/rule/post&m=basic','fa fa-plus',0,1,1,'platform'),
	(27,10000,'管理','','','','',0,1,1,'package'),
	(30,2,'图文回复','platform_reply_news','?s=site/rule/lists&m=news','?s=site/rule/post&m=news','fa fa-plus',0,1,1,'platform'),
	(32,0,'会员粉丝','','?s=site/entry/home','','fa fa-cubes',10,1,1,'member'),
	(33,32,'会员中心','','','','fa fa-cubes',0,1,1,'member'),
	(35,33,'会员','member_users','?m=member&action=controller/site/memberlists','?m=member&action=controller/site/MemberPost','fa fa-cubes',0,1,1,'member'),
	(36,33,'会员组','member_groups','?m=member&action=controller/site/groupLists','?m=member&action=controller/site/groupPost','fa fa-cubes',0,1,1,'member'),
	(38,32,'积分兑换','','','','fa fa-cubes',0,1,1,'member'),
	(39,38,'折扣券','member_coupons','?m=ticket&action=controller/site/lists&type=1','?m=ticket&action=controller/site/post&type=1','fa fa-cubes',0,1,1,'member'),
	(40,38,'折扣券核销','member_coupons_charge','?m=ticket&action=controller/site/charge&type=1','','fa fa-cubes',0,1,1,'member'),
	(41,38,'代金券','member_cash','?m=ticket&action=controller/site/lists&type=2','?m=ticket&action=controller/site/post&type=2','fa fa-cubes',0,1,1,'member'),
	(42,38,'代金券核销','member_cash_charge','?m=ticket&action=controller/site/charge&type=2','','fa fa-cubes',0,1,1,'member'),
	(55,2,'系统回复','platform_reply_special','?m=special&action=controller/site/post','','fa fa-cubes',0,1,1,'platform'),
	(63,100,'支付配置','','','','fa fa-cubes',0,1,1,'feature'),
	(64,63,'微信支付配置','feature_setting_pay','?s=site/setting/pay','','fa fa-cubes',0,1,1,'feature'),
	(66,100,'会员选项','','','','fa fa-cubes',0,1,1,'feature'),
	(67,66,'会员积分设置','feature_setting_credit','?s=site/setting/credit','','fa fa-cubes',0,1,1,'feature'),
	(68,66,'登录注册选项','feature_setting_register','?s=site/setting/register','','fa fa-cubes',0,1,1,'feature'),
	(70,66,'邮件通知设置','feature_setting_mail','?s=site/setting/mail','','fa fa-cubes',0,1,1,'feature'),
	(71,0,'文章系统','','?s=site/entry/home','','fa fa-cubes',0,1,1,'article'),
	(72,71,'官网管理','','?s=article/home/welcome','','fa fa-cubes',0,1,1,'article'),
	(73,72,'官网模板','article_site_template','?m=article&action=controller/template/lists','','fa fa-cubes',0,1,1,'article'),
	(74,71,'内容管理','','','','fa fa-cubes',0,1,1,'article'),
	(75,74,'分类管理','article_category_manage','?m=article&action=controller/category/lists','?m=article&action=controller/category/post','fa fa-cubes',0,1,1,'article'),
	(76,74,'文章管理','article_manage','?m=article&action=controller/content/lists','','fa fa-cubes',0,1,1,'article'),
	(77,72,'站点设置','article_site_manage','?m=article&action=controller/site/post','','fa fa-cubes',0,1,1,'article'),
	(78,100,'特殊页面','','','','fa fa-cubes',0,1,1,'article'),
	(80,78,'手机会员中心','feature_ucenter_post','?m=ucenter&action=controller/style/post','','fa fa-cubes',0,1,1,'feature'),
	(81,27,'扩展功能管理','package_managa','?s=site/entry/home','','fa fa-cubes',0,1,1,'package'),
	(82,1,'高级功能','','','','fa fa-cubes',0,1,1,'platform'),
	(84,33,'会员字段管理','member_fields','?m=member&action=controller/site/fieldlists','','fa fa-cubes',0,1,1,'member'),
	(85,78,'微站快捷导航','feature_quick_menu','?s=site/navigate/quickmenu','','fa fa-cubes',0,1,1,'feature'),
	(86,82,'微信菜单','platform_menus_lists','?m=button&action=controller/site/lists','','fa fa-cubes',0,1,1,'platform'),
	(87,1,'微信素材','','','','fa fa-cubes',0,1,1,'platform'),
	(88,87,'素材&群发','platform_material','?m=material&action=controller/site/image','','fa fa-cubes',0,1,1,'platform'),
	(89,100,'系统管理','','','','fa fa-cubes',0,1,1,'feature'),
	(90,89,'更新站点缓存','feature_system_update_cache','?s=site/site/updateCache','','fa fa-cubes',0,1,1,'feature'),
	(91,89,'快捷菜单设置','feature_system_quicknavigate','?m=quicknavigate&action=controller/site/status','','',0,1,1,'feature'),
	(92,72,'导航菜单','article_navigate_lists','?s=site/navigate/lists&entry=home&m=article','?s=site/navigate/post&m=article&entry=home','',0,1,1,'article'),
	(93,74,'模型管理','article_model_manage','?m=article&action=controller/model/lists','?m=article&action=controller/model/post','fa fa-cubes',0,1,1,'article'),
	(94,66,'短信发送设置','feature_setting_mobile','?s=site/setting/mobile','','fa fa-cubes',0,1,1,'feature'),
	(100,0,'系统设置','','?s=site/entry/home','','fa fa-comments-o',20,1,1,'feature'),
	(101,89,'站点全局设置','feature_system_site_config','?s=site/setting/config','','fa fa-cubes',0,1,1,'feature'),
	(102,100,'云帐号','','','','fa fa-cubes',0,1,1,'feature'),
	(103,102,'阿里云配置','feature_system_aliyun_config','?s=site/setting/aliyun','','fa fa-cubes',0,1,1,'feature'),
	(10000,0,'扩展模块','','?s=site/entry/home','','fa fa-arrows',100,1,1,'package'),
	(10001,72,'轮换图片','article_site_slide','?m=article&action=controller/slide/lists','?m=article&action=controller/slide/post','fa fa-cubes',0,1,1,'article'),
	(10002,72,'访问域名','article_domain_set','?s=site/domain/post&m=article','','fa fa-cubes',0,1,1,'article');
str;
        Db::execute($sql);
    }

    //回滚
    public function down()
    {

    }
}