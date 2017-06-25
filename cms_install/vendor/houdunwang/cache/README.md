# 缓存

缓存组件提供了多种高效的缓存处理方式，包括数据缓存、静态缓存和查询缓存等，提供多种缓存类型，并提供了快捷方法进行存取操作
登录 [GITHUB](https://github.com/houdunwang/cache)  查看源代码

[TOC]
##开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/cache
```
> HDPHP 框架已经内置此组件，无需要安装

####配置参数
```
$config = [
	/**
	 * 组件支持多种缓存驱动
	 * 修改驱动为:file memcache redis mysql即可更改缓存机制
	 * memcache、redis需要自行安装服务器软件
	 * mysql缓存需要创建数据表
	 */
	'driver'   => 'file',
	/**
	 * 文件缓存
	 */
	'file'     => [
		'dir' => 'storage/cache'
	],
	/**
	 * memcache缓存
	 * 多个服务器设置二维数组
	 */
	'memcache' => [
		'host' => '127.0.0.1',
		'port' => 11211,
	],
	/**
	 * redis缓存
	 * 多个服务器设置二维数组
	 */
	'redis'    => [
		'host'     => '127.0.0.1',
		'port'     => 6379,
		'password' => '',
		'database' => 0,
	],
	/**
	 * mysql缓存
	 */
	'mysql'    => [
		//缓存表
		'table'    => 'core_cache'
	]
];
\houdunwang\config\Config::set('cache',$config);
```

## 基本操作

####设置

```
\houdunwang\cache\Cache::set('data',['name'=>'houdunwang.com'],3600);
//缓存数据3600秒
```

####获取
```
Cache::get('data');
```

####删除
```
Cache::del('data');
```

####清空
```
Cache::flush();
```

####驱动
系统支持项目中临时使用其他驱动类型的缓存
```
Cache::driver('file')->set('name','后盾网');
```

####目录
设置缓存目录只对文件类型的缓存驱动有效
```
Cache::dir('storage/cache/view')->set('name','后盾网');
```

#文件缓存
系统针对文件缓存组件提供了方便的函数式操作。

####创建
以默认缓存目录设置缓存，默认缓存目录为 storage/cache

```
f('hd','houdunwang.com');
```

####获取
```
f('hd');
```

####指定缓存目录

```
f('hd','houdunwang.com',3600,'storage/cache');
```

####获取指定目录的缓存
时间在这里没有效果，但必须指定
```
f('hd','[get]',3600,'storage/cache');
```

####删除缓存

```
f('hd','[del]')
```
####删除所有缓存

```
f(null);
```

####删除指定目录的缓存

时间在这里没有效果，但必须指定
```
f('hd','[del]',3600,'storage/cache/field');
```

##数据库缓存
针对数据库缓存操作系统提供了快捷的 d 函数操作。

数据库缓存依赖 [Db数据库组件](https://github.com/houdunwang/db)
####创建表
请执行以下SQL创建缓存表
```
CREATE TABLE `core_cache` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `data` text,
  `create_at` int(10) unsigned DEFAULT NULL,
  `expire` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
```

####设置数据库连接配置
数据库连接配置请参考 [GitHub文档](https://github.com/houdunwang/db) 。

####添加
```
d('hd',array('name'=>'后盾人');
```

####获取
```
d('hd');
```

####删除

```
d('hd','[del]')
```

####删除所有
```
d(null);
```