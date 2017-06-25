#工具

工具组件包含开发中常用的一些小功能。

[TOC]

#开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/tool
```
> HDPHP 框架已经内置此组件，无需要安装

####生成随机数
```
//生成10位随机数
Tool::rand(10);
```

####批量执行函数
```
$funcs=['md5','strtoupper'];
$value='houdunwang';
Tool::batchFunctions($funcs,$value);
//一个函数时的执行
Tool::batchFunctions('md5','hdphp');
```

####可识别的单位
根据大小返回标准单位 KB  MB GB等
```
Tool::getSize(20000,2);
//计算20000是GB还是MB，并返回2位小数
```