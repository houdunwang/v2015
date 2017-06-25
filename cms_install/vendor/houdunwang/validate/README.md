#自动验证
Validate组件提供了方便的验证机制，快速实现验证业务。
[TOC]
##安装
使用 composer 命令进行安装或下载源代码使用。
验证组件依赖 [Session组件](https://github.com/houdunwang/session) 与 [Cookie组件](https://github.com/houdunwang/cookie), 请先对这两个组件进行配置才可以使用本组件。
```
composer require houdunwang/validate
```
> HDPHP 框架已经内置此组件，无需要安装

####配置
```
$config = [
	/**
	 * 验证错误显示类型
	 * redirect 直接跳转,会分配$errors到前台
	 * show 直接显示错误信息
	 * default 由开发者自行处理
	 */
	'dispose' => 'redirect',
	//发生错误时的显示模板
	'view'    => 'resource/bug.php'
];
\houdunwang\config\Config::set( 'validate', $config );
```

##使用
####系统规则
```
required                 	必须输入
email                    	邮箱
http                        网址
tel                         固定电话
phone                    	手机
zipCode                     邮政编码
num                      	数字范围 如：num:20,60
range                       长度范围(位数)如 :range:5,20
maxlen                   	最大长度如：maxlen:10
minlen                   	最小长度如：minlen:10
regexp                      正则如：regexp:/^\d{5,20}$/ 
confirm                  	两个字段值比对如：confirm:password2
china                   	验证中文
identity                	身份证
unique					   数据表值唯一如:unique:news,id (id为表主键）
exists					    存在字段时验证失败
captcha					 验证码
```
####基本语法
```
array(字段名,验证方法,错误信息,验证条件)
验证条件 (可选)： 
	1	有字段时 
	2	值不为空时
	3	必须处理 (默认)
	4	值为空时
	5   不存在字段时处理
```

####闭包验证
```
\houdunwang\validate\Validate::make(
    [
        ['domain', function ($value) {
            return $value > 100;
        }, '域名不能为空', 3 ]
	]);
//闭包返回 true 时验证通过
```

####验证表字段唯一性
```
\houdunwang\validate\Validate::make( [
	[ 'qq', 'unique:user,uid', 'qq已经存在', 3 ]
	// user ：表名  uid：表主键
] );
```

####验证表单验证码
```
\houdunwang\validate\Validate::make( [
 [ 'code', 'captcha', '验证码输入错误', 3 ]
 ] );
```

##处理方式
验证响应由配置文件 system/config/error.php 中的app 配置段决定。

####redirect
直接跳转,会分配变量$errors到前台，开发者可以通过模板标签读取错误内容。

####show
直接显示错误信息，不需要开发者处理

####default
由开发者自行处理，需要使用  \houdunwang\validate\Validate::fail()自行进行判断。

##扩展使用
####增加规则
```
\houdunwang\validate\Validate::extend('checkUser',function($field,$value,$params){
	//返回值为true时验证通过
		return true;
});
```
第一个参数为验证规则名称，第二参数闭包函数。

####验证判断
需要响应方式为default值时有效。
```
if(\houdunwang\validate\Validate::fail()){
	echo '验证失败';
};
```

####链式操作
```
\houdunwang\validate\Validate::make(array(
        array('username','required|email','邮箱不能为空')
    ))->fail();
```

####获取错误信息
错误信息会记录到模型对象的 error 属性中，使用 getError() 方法获取但需要设置处理方式为 default
```
\houdunwang\validate\Validate::getError();
```



