# 压缩&解压
zip压缩组件提供方便快捷的压缩与解压缩功能。

####创建实例

```
$obj = new \houdunwang\zip\PclZip();
```
####压缩目录

```
$obj->PclZip('addons.zip');//设置压缩文件名
$obj->create('addons');//压缩addons目录
```

####压缩文件

```
$obj->PclZip('index.zip');//设置压缩文件名
$obj->create('index.php');//压缩index.php文件
```

####解压缩

```
$obj->PclZip('addons.zip');//设置压缩文件名
$obj->extract();//解压缩到当前目录
$obj->extract('zip');//解压缩到hd目录
```