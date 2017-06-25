# 加密解密

##介绍

加密组件提供快捷的加密解密操作, 使用设置的密钥实现安全的数据加密处理。

[TOC]

#开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/crypt
```
> HDPHP 框架已经内置此组件，无需要安装

##配置

####配置设置
Crypt组件依赖Config配置组件，所以我们可以使用Config组件设置加密密钥。
```
$key="sdkdsklldsksdksdksdkldsklsdkllksd";
\houdunwang\config\Config::set('app.key',$key);
```

####设置密钥
也可以通过函数key设置加密密钥。
```
$key="sdkdsklldsksdksdksdkldsklsdkllksd";
\houdunwang\crypt\Crypt::key($key);
```

##基本使用
####加密
```
$encrypted = \houdunwang\crypt\Crypt::encrypt('后盾人  人人做后盾');
```
####解密
```
$decrypted = \houdunwang\crypt\Crypt::decrypt($encryptedValue);
```

####自定义密钥
```
//自定义密钥,解密时使用相同密钥才可解
$encrypted = \houdunwang\crypt\Crypt::encrypt('后盾网  人人做后盾',md5('houdunwang.com'));

//自定义密钥,使用加密时相同的密钥才可解
$decrypted = \houdunwang\crypt\Crypt::decrypt($encryptedValue,md5('houdunwang.com'));
```

##函数

####加密
encrypt函数加密不使用 [应用密钥](http://doc.hdphp.com/226446) 所以密钥更新后不影响解密，适合于对用户密码等持久数据进行加密。
```
encrypt('admin888');
```

####解密
用于解密经由 encrypt 加密后的内容。
```
decrypt('解密内容');
```