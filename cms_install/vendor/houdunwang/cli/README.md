# 命令行操作组件

使用cli组件用于操作命令行动作

登录 [GITHUB](https://github.com/houdunwang/cli)  查看源代码

[TOC]
#开始使用

##安装组件
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/cli
```
> HDPHP 框架已经内置此组件，无需要安装

##配置
命令行工具用于创建相关文件，所以需要设置不同类型文件创建的目录。

####设置文件储存目录
```
$obj->setPath([
  'controller' => 'app/controller',
  'middleware' => 'app/middleware',
  'migration'  => 'app/migration',
  'model'      => 'app/model',
  'request'    => 'app/request',
  'seed'       => 'app/seed',
  'service'    => 'app/service',
  'tag'        => 'app/tag',
  'test'       => 'tests',
]);
```

####数据库连接配置
很多命令是用于创建表或修改表结构，所以需要设置连接数据库的配置。
配置使用 [https://github.com/houdunwang/config](https://github.com/houdunwang/config) 组件管理，请查看文档设置配置项。

##创建命令脚本 
创建命令脚本如hd 内容如下
```
require 'vendor/autoload.php';
\houdunwang\config\Config::loadFiles('config');
\houdunwang\cli\Cli::bootstrap();
```

##添加命令

####批量添加命令
使用setBinds可以指定添加命令，参数为命令执行类的数组。
```
\houdunwang\cli\Cli::setBinds(
    ['app/Cli.php']
);
```

###绑定命令
绑定命令使用闭包进行操作,闭包中的第一个参数为Cli组件实例。
```
\houdunwang\cli\Cli::setBinds( 'hd', function ( $cli, $arg1, $arg2 ) {
	echo $arg1, $arg2;
	//正确提示信息
	$cli->success( '操作成功' );
	
	//错误提示信息
    $cli->error( '执行失败' );
});
```
