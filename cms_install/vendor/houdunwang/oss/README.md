# 阿里云OSS
本服务用于管理阿里云OSS,本服务是对阿里云SDK的封装，所以方法名与阿里的SDK一样，下面是列举出的几个使用方法，其他OSS方法都是可以使用的，请参考阿里云 [OSS参考文档](https://help.aliyun.com/document_detail/32103.html?spm=5176.doc32099.6.748.85Qz6b)。
[TOC]

####安装组件
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/oss
```

##组件配置
|   配置 | 查看   |
| --- | --- |
|   endPoint | 登录某个块查看 bucket概览 |
|   accessId |  登录阿里云后台查看右上角的 "访问控制(使用子帐号)" 或 "accesskeys(使用主帐号)"  |
|   accessKey |  同上 accessId  |

```
Config::set('oss',[
	'accessKeyId'=>'',
	'accessKeySecret'=>'',
	//外网Endpoint OSS开通Region和Endpoint对照表: https://help.aliyun.com/document_detail/31837.html
	'endpoint'=>'oss-cn-hangzhou.aliyuncs.com',
	//OSS块标识
	'bucket'=> "houdunren"
	]
);
```

##字符串上传
```
$object = "hd.txt";
$content = "Hi, OSS.";
Oss::putObject($object, $content);
```

##上传本地文件
```
$object = "1.mp4";
$filePath = '/www/1.mp4';
Oss::uploadFile($object, $filePath);
```