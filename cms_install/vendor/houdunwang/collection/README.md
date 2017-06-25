# 集合 

Collection 组件提供一个流畅、方便的封装来操作数据。

> 集合中的数据可以使用数组形式调用也可以使用foreach等循环读取

登录 [GITHUB](https://github.com/houdunwang/mail)  查看源代码

[TOC]
# 开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/collection
```

####建立集合
使用对象创建
```
$collection = Collection::make([1, 2, 3]);
```

使用函数创建
```
$collection = collect([1, 2, 3]);
```

####转换数组
```
Collection::make([1, 2, 3])->toArray();
```


####读取数据
```
$collection = Collection::make(['name'=>'后盾人]);
$collection['name'];
```

####遍历数据
```
$collection = Collection::make([1, 2, 3]);
foreach($collection as $v){
	print_r($v);
}
```