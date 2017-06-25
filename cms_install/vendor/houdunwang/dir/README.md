# 目录操作

目录组件用于对常用目录操作的实现

[TOC]
##开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/dir
```

####创建目录
```
Dir::create('Home/View');
```

####删除目录
```
Dir::del('Home');
```

####复制目录
```
Dir::copy('a','b');
```

####删除文件
```
Dir::delFile($file);
```

####移动目录
```
Dir::move('a','b');
```

####目录树
```
Dir::tree('Home');
```

####目录大小
```
Dir::size('Home');
```

####移动文件
```
Dir::moveFile('hd.php','data');
//将hd.php 移动到data目录
```

####复制文件
```
Dir::copyFile('README.md', 'tests/README.md')
```