# 语言

组件提供便捷的多语言支持，程序开发人员只需要配置好语言包即可实现多语言环境构建。 
其他产品也可以使用该组件，请登录 [GITHUB](https://github.com/houdunwang/lang) 查看源代码与说明文档。

[TOC]

##安装
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/lang
```

##操作
####配置
```
Config::set( 'lang.lang', 'system/zh.php' );
echo Lang::get( 'name' );
```

####设置语言包
除了可以使用配置文件外,也可以使用file() 方法动态设置语言包
```
Lang::file('zh.php');
```

####获取语言
```
echo Lang::get('web');
```

####设置语言
```
echo Lang::set('name','向军老师');
```