#验证码

验证码组件用于生成网页中的验证码图像。

验证码组件依赖 [Session组件](https://github.com/houdunwang/session) 对生成的验证码数据进行保存。

[TOC]
####安装

```
composer require houdunwang/code
```

####配置
验证码使用SESSION 组件中使用了 [Session组件](https://github.com/houdunwang/session) 进行管理, 如果已经对Session组件进行了配置则不需要执行以下代码,否则请执行以下代码来配置 [Session组件](https://github.com/houdunwang/session)。
```
$config = [
	//引擎:file,mysql,memcache,redis
	'driver'    => 'file',
	//session_name
	'name'      => 'hdcmsid',
	//cookie加密密钥
	'secureKey' => 'houdunwang88',
	//储存目录
	'file'      => [
		'path' => 'storage/session',
	],
];
\houdunwang\config\Config::set( 'session', $config );
```

####显示验证码
```
Code::make();
```

####验证表单验证码是否正确
```
Code::auth( 'code' )
//code 为$_POST表单字段名
```

####获取验证码文字
```
echo Code::get();
```

####设置验证码宽度与高度
```
Code::width(200)->height(100)->make();
```

####设置验证码文字大小与文字颜色

```
Code::fontSize(20)->fontColor('#f00f00')->make();
```

####设置验证码背景颜色
```
Code::background('#999999')->make();
```

####设置验证码数量

```
Code::num(10)->make();
```

####设置验证码字体文件
```
Code::font('public/font.ttf')->make();
```