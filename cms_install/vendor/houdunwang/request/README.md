# 响应组件

##介绍
Request服务是用于获取请求数据与对请求终端设备进行判断的服务。 

> 使用 Request 组件前必须先行配置 [Session组件](https://github.com/houdunwang/session) 与 [Cookie组件](https://github.com/houdunwang/cookie),请参考GitHub文档进行参考

[TOC]

#开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用。
```
composer require houdunwang/request
```
> HDPHP 框架已经内置此组件，无需要安装

####启动组件
```
\houdunwang\request\Request::bootstrap();
```

####常量定义
组件会定义一些常量
```
IS_GET      GET请求
IS_POST     POST请求
IS_DELETE   DELETE请求
IS_PUT      PUT请求
IS_AJAX     异步请求
IS_WECHAT   微信客户端请求
__URL__     当前请求完整URL
__HISTORY__ 来源地址
```

####判断请求类型
```
Request::isMethod('post');
判断类型支持 get/post/delete/put类型的判断
```
####获取数据
query 方法支持点语法操作，支持多层数据获取。第一个字符为数据类型。
```
Request::query('post.data.id');
```

####不存在时返回默认值
返回默认值指当数据不存在时返回设置的值，并不会更改原数据。
以下示例当 $_GET['id']不存在时返回默认值9
```
Request::query('get.id',9);
```

####对数据函数处理
query 方法的第三个参数是一个函数名组成的数组，将对获取的数据通过函数进行处理后返回。
```
Request::query('get.id',0,['intval','trim']);
```

####根据类型获取
系统支持使用 get,post,request,server,session,cookie,global获取同名的php全局变量数据。

#####获得所有 $_GET 数据
```
Request::get('cid',0,'intval'); 
//获取$_GET['cid']值 ，存在时使用intval函数处理，不存在时定义为0
```

#####获得所有 $_POST 数据
```
Request::post(); 
```

#####获得POST变量并对数据执行函数处理
```
Request::post('webname',NULL,['htmlspecialchars','strtoupper']); 
```

#####获得POST变量, 不存时返回默认值
```
Request::post('webname','后盾网'); 
```

#####获得 $_SESSION['uid'] 值，并执行intval方法
```
Request::session('uid',0,'intval'); 
```

#####获得 $_COOKIE['cart'] 值
```
Request::cookie('cart'); 
```

####设置
使用set 方法可以为$_GET,$_POST,$_REQUEST,$_SERVER设置数据，支持点语法设置多层数据，第一个参数为数据类型。
以下代码设置GET['a']['b'] 变量为后盾人
```
Request::set('get.a.b','后盾人');
```

####获取客户端IP地址
```
Request::ip();
```

####https请求检测
```
Request::isHttps();
```

####判断是否为手机访问
```
Request::isMobile();
```

####检测是否为微信客户端
```
Request::isWeChat();
```

####判断请求来源是否为本站域名
```
Request::isDomain();
```
