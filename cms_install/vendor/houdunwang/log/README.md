# 日志管理

##介绍
网站错误日志处理组件

[TOC]
#开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用。
```
composer require houdunwang/log
```
> HDPHP 框架已经内置此组件，无需要安装

####配置
```
$config = [
    //日志保存目录
	'dir' => 'log'
];
\houdunwang\config\Config::set( 'log', $config );
```

####写入日志
执行以下方法将直接写入日志到文件中。

```
\houdunwang\log\Log::write('系统错误',\houdunwang\log\Log::ERROR);
//参数说明: a: 错误内容  b:错误等级
/**
错误等级类常量:
const FATAL = 'FATAL';          // 严重错误: 导致系统崩溃无法使用
const ERROR = 'ERROR';          // 一般错误: 一般性错误
const WARNING = 'WARNING';      // 警告性错误: 需要发出警告的错误
const NOTICE = 'NOTICE';        //通知: 程序可以运行但是还不够完美的错误
const DEBUG = 'DEBUG';          //调试: 调试信息
const SQL = 'SQL';              //SQL：SQL语句 注意只在调试模式开启时有效
const EXCEPTION = 'EXCEPTION';  //异常错误
*/
```

####记录日志
记录日志会在请求结束时自动加入文件中
```
\houdunwang\log\Log::record('系统错误',\houdunwang\log\Log::ERROR);
```