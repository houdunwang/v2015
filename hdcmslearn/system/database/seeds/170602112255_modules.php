<?php namespace system\database\seeds;

use houdunwang\database\build\Seeder;

class modules extends Seeder
{
    //执行
    public function up()
    {
        $sql
            = <<<str
INSERT INTO `hd_modules` (`mid`, `name`, `industry`, `title`, `version`, `resume`, `detail`, `author`, `url`, `is_system`, `subscribes`, `processors`, `setting`, `router`, `tag`, `rule`, `crontab`, `permissions`, `thumb`, `preview`, `locality`, `domain`, `build`, `middleware`)
VALUES
	(1,'basic','business','基本文字回复','1.0','和您进行简单对话','一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 将回复文字或链接给用户','后盾','http://www.hdcms.com','1','','{\"text\":true}',0,0,0,0,0,'','thumb.png','cover.jpg',1,0,'0',0),
	(2,'news','business','微信图文回复','1.0','为你提供生动的图文资讯','一问一答得简单对话. 当访客的对话语句中包含指定关键字, 或对话语句完全等于特定关键字, 将回复文字或链接给用户','后盾','http://www.hdcms.com','1','','{\"text\":true}',0,0,0,0,0,'','thumb.png','cover.jpg',1,0,'0',0),
	(3,'article','business','文章系统','1.0','发布文章与会员中心管理','支持桌面、移动、微信三网的文章系统，同时具有移动、桌面会员中心管理功能','后盾','http://www.hdcms.com','1','','',0,0,0,0,0,'','thumb.png','cover.jpg',1,0,'0',0),
	(5,'member','business','会员粉丝','1.0','会员管理','会员与会员组管理，如会员字段，粉丝管理、会员卡设置','后盾','http://www.hdcms.com','1','','{\"subscribe\":true}',0,0,0,0,0,'','thumb.png','cover.jpg',1,0,'0',0),
	(6,'special','business','微信默认消息','1.0','微信默认消息','系统默认消息与关注微信消息处理','后盾','http://www.hdcms.com','1','','',0,0,0,0,0,'','thumb.png','cover.jpg',1,0,'0',0),
	(7,'ticket','business','卡券管理','1.0','会员卡券管理','会员优惠券、代金券、实物券管理','后盾','http://www.hdcms.com','1','','',0,0,0,0,0,'','thumb.png','cover.jpg',1,0,'0',0),
	(8,'cover','business','封面回复','1.0','封面消息回复','用来处理模块的封面消息','后盾','http://www.hdcms.com','1','','{\"text\":true}',0,0,0,0,0,'','thumb.png','cover.jpg',1,0,'0',0),
	(10,'button','business','微信菜单','1.0','微信菜单管理','用于添加微信菜单，更新菜单后需要取消关注再关注或等微信更新缓存后有效','后盾','http://www.hdcms.com','1','','',0,0,0,0,0,'','thumb.png','cover.jpg',1,0,'0',0),
	(11,'material','business','微信素材','1.0','微信素材','公众号经常有需要用到一些临时性的多媒体素材的场景，例如在使用接口特别是发送消息时，对多媒体文件、多媒体消息的获取和调用等操作','后盾','http://www.hdcms.com','1','','',0,0,0,0,0,'','thumb.png','cover.jpg',1,0,'0',0),
	(12,'ucenter','business','会员中心','1.0','会员中心管理模块','提供移动端与桌面端的会员中心操作功能','后盾','http://www.hdcms.com','1','','',0,0,1,0,0,'','thumb.png','cover.jpg',1,0,'0',0),
	(14,'link','business','链接管理','1.0','管理站点中的链接','主要用在调用链接组件，选择链接等功能时使用','后盾','http://www.hdcms.com','1','','',0,0,0,0,0,'','thumb.png','cover.jpg',1,0,'0',0),
	(1000,'quicknavigate','business','快捷菜单','1.0','站点管理中的快捷菜单操作','用在后台底部快捷导航菜单的管理操作功能','后盾','http://www.hdcms.com','1','','',0,0,0,0,0,'','thumb.png','cover.jpg',1,0,'0',0);
str;
        Db::execute($sql);
    }

    //回滚
    public function down()
    {

    }
}