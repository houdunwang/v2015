# 数据库
数据库组件用于完成数据库、表、记录的管理。

登录 [GITHUB](https://github.com/houdunwang/database)  查看源代码

[TOC]
##安装组件
使用 composer 命令进行安装或下载源代码使用。
```
composer require houdunwang/database
```
> HDPHP 框架已经内置此组件，无需要安装

##开始使用
####配置
本组件使用了 [Db组件](https://github.com/houdunwang/db) 需要先进行配置, 请查看 [GitHub文档](https://github.com/houdunwang/db) 进行配置

####获取表字段信息
获取user表的所有字段
```
Schema::getFields('user');
```

####获取表主键
```
Schema::getPrimaryKey('user');
```

####删除表
```
Schema::drop('news');
```

####修复表
```
Schema::repair('user'); 
```

####优化表
```
Schema::optimize('user'); 
```
####获取数据库大小
获得当前数据库大小即所有表碎片、数据、索引之和 
```
Schema::getDataBaseSize('hdphp')
```

####获取表大小
获得 news 表大小,包含表碎片、数据、索引之和 
```
Schema::getTableSize('news'); 
```

####锁表
```
Schema::lock('ticket_record,ticket,member');
//多个表用半角逗号分隔
Schema::lock('user as u,member as m');
//锁定具有设置表前缀的表，多用在多表关联操作时
```

####解锁表
```
Schema::unlock();
```

####清空表
```
Schema::truncate('user');
```

####获所有表信息
获得当前数据库的所有表信息 , 数据大小包括碎片、数据、索引 
```
Schema::getAllTableInfo('hdphp')
```

####检测表是否存在
```
Schema::tableExists('comment');
```

####测表字段是否存在
```
Schema::fieldExists('title','news');

检测 news 表是否存在 title 字段
```

####执行多条SQL语句
```
$sql = <<<EOF
	CREATE TABLE `hd_core_attachment` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`uid` int(11) NOT NULL COMMENT '会员id',
	`filename` varchar(300) NOT NULL COMMENT '文件名',
	`path` varchar(300) NOT NULL COMMENT '相对路径',
	`type` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
	`createtime` int(10) NOT NULL COMMENT '上传时间',
	`size` mediumint(9) NOT NULL COMMENT '文件大小',
	`user_type` tinyint(1) DEFAULT NULL COMMENT '1 管理员 0 会员',
	PRIMARY KEY (`id`),
	KEY `uid` (`uid`)
	) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='附件';

	CREATE TABLE `hd_rule` (
	`rid` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`siteid` int(10) unsigned NOT NULL COMMENT '站点编号',
	`name` varchar(45) DEFAULT NULL COMMENT '规则名称',
	`module` varchar(45) DEFAULT NULL COMMENT '模块名称',
	`rank` tinyint(3) unsigned DEFAULT NULL COMMENT '排序',
	`status` tinyint(1) unsigned DEFAULT NULL COMMENT '是否禁用',
	PRIMARY KEY (`rid`),
	KEY `fk_hd_rule_hd_site1_idx` (`siteid`)
	) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='回复规则';
EOF;
Schema::sql($sql);
```