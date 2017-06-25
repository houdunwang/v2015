# 配置

Config组件用于完成网站配置项管理。

登录 [GITHUB](https://github.com/houdunwang/config)  查看源代码

[TOC]
#开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/config
```
> HDPHP 框架已经内置此组件，无需要安装


####设置配置
加载.env文件
```
#参数为.env文件所在目录
Config::env(dirname(__DIR__));
```

一个简单的env内容如下:

```
DB_DRIVER=mysq22l
DB_HOST=127.0.0.1
DB_DATABASE=hdphp
DB_USER=root
DB_PASSWORD=
```

读取env文件内容
```
env('DB_HOST','localhost');
```
读取.env文件中的 DB_HOST配置，如果为空时使用 localhost

####设置配置
```
\houdunwang\config\Config::set('alipay.key.auth','houdunwang');
```

####加载所有文件
```
//加载config目录下的所有文件到配置容器中
\houdunwang\config\Config::loadFiles('config');
```

####设置多个配置
```
\houdunwang\config\Config::batch(['app.debug'=>true,'database.host'=>'localhost']);
```

####检测配置
```
\houdunwang\config\Config::has('web.master');
```

####获取配置
如果想要获取配置文件的所有内容，只传递文件名就可以：
```
\houdunwang\config\Config::get('app');
```

####获取子元素
获取配置文件使用 get 方法完成，参数为 ”配置文件名.配置项"的形式。
```
\houdunwang\config\Config::get('view.path');
```

####获取所有
也可以使用 all 方法获取所有配置，例如：
```
\houdunwang\config\Config::all();
```

####排除批定字段
```
\houdunwang\config\Config::getExtName('database',['write','read']);
```

# c 函数
c函数是用来快速获取/设置配置项的

####获得所有
```
c();
```

####设置
```
c('alipay.key.auth','houdunwang');
```

####获取
```
c('alipay.key.auth');
```