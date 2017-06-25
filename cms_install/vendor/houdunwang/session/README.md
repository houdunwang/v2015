#SESSION组件

##介绍

组件提供高效的SESSION管理手段, 提供多种处理引擎包括File、Mysql、Memcache、Redis等,支持统一调用接口使用方便。
组件使用了 [Cookie组件](https://github.com/houdunwang/cookie) 进行COOKIE管理, 请查看 [GitHub文档](https://github.com/houdunwang/cookie) 进行配置。

[TOC]

#开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/session
```
> HDPHP 框架已经内置此组件，无需要安装

##配置
####基本配置
```
$config = [
	//session_name
	'name'      => 'hdcmsid',
	//有效域名
	'domain'    => '',
	//过期时间 0 会话时间 3600 为一小时
	'expire'    => 0,
	#File引擎配置
	'file'      => [
		'path' => 'storage/session',
	],
	#Mysql引擎配置
	'mysql'     => [
		//缓存表
		'table'    => 'session'
	],
	#Memcache引擎配置
	'memcache'  => [
		'host' => 'localhost',
		'port' => 11211,
	],
	#Redis引擎配置
	'redis'     => [
		'host'     => 'localhost',
		'port'     => 11211,
		'password' => '',
		'database' => 0,
	]
];
\houdunwang\config\Config::set( 'session', $config );
```
####数据库引擎
如果SESSION处理使用数据库引擎, 请参考 [Db数据库组件](https://github.com/houdunwang/db) 文档进行配置。

##使用
####设置
```
Session::set('name','houdunwang.com');
```

####闪存
通过 flash 指令设置的数据会在下次请求结束时自动删除, 这类动作我们称为闪存数据。

```
Session::flash('name','houdunren.com');
```

####获取
```
Session::get('name');
```

####获取所有
```
Session::all();
```

####判断
```
Session::has('name');
```

####删除
```
Session::del('name');
```

####清空
删除所有数据
```
Session::flush();
```