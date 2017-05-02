#上传组件

HDPHP 提供非常方便的上传处理机制，上传类会返回所有上传成功的文件列表。

##使用

####实例化对象
```
$obj = new \houdunwang\upload\Upload();
```

####初始化配置

```
//初始化配置
$obj->init( [
	//允许上传类型
	'type' => 'jpg,jpeg,gif,png,zip,rar,doc,txt,pem',
	//允许上传大小单位KB
	'size' => 10000,
	//上传路径
	'path' => 'attachment',
] );
```

####上传文件

```
$files = $obj->make();
```

####指定上传表单

```
$obj->make('ico');
```
####设置上传类型

```
$obj->type('jpg,png,txt')->make();
```

####设置上传大小

```
$obj->type('jpg,png,txt')->size(2000000)->make();
```

####获取上传错误

```
$obj->getError();
```

####设置上传目录

```
$obj->path('News')->make();
```