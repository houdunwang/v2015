# RBAC
##介绍
基于角色的访问控制（Role-Based Access Control）作为传统访问控制（自主访问，强制访问）的有前景的代替受到广泛的关注。在RBAC中，权限与角色相关联，用户通过成为适当角色的成员而得到这些角色的权限。这就极大地简化了权限的管理。

其他产品也可以使用该组件，请登录 [GITHUB](https://github.com/houdunwang/rbac) 查看源代码与说明文档。

组件使用依赖 [Session组件](https://github.com/houdunwang/session) 与 [Db组件](https://github.com/houdunwang/db) 请参考相关组件文档先进行配置后才可以使用RBAC组件。

[TOC]

##安装
使用 composer 命令进行安装或下载源代码使用。

```
composer require houdunwang/rbac
```
> HDPHP 框架已经内置此组件，无需要安装

####数据表
RBAC权限控制使用数据库进行管理，需要先创建使用的数据表。
```
CREATE TABLE IF NOT EXISTS `access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  KEY `role_id` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  `show` tinyint(1) unsigned NOT NULL default 1,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `user` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,auto_increment,
  `username` char(20) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
   PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
CREATE TABLE IF NOT EXISTS `user_role` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
```

####配置
```
$config = array(
    //1时时认证｜2登录认证
 	'type'                      => 1,           
    
    //站长名称（站长不需要验证）
    'super_user'               => 'admin', 
    
    //用户名字段
    'username_field'            => 'username',  
    
    //密码字段
    'password_field'            => 'password',  
    
    //用户SESSION名
    'auth_key'                  => 'id',       
    
    //不需要验证请求: array('Admin.User.add')
    //Admin模块 User控制器 add动作 不需要验证
    'no_auth'                   => array(),     

    //用户角色表
    'user_table'                => 'user',      

    //角色表
    'role_table'                => 'role',      

    //节点表
    'node_table'                => 'node',      

    //角色与用户关联表
    'user_role_table'           => 'user_role',

    //权限分配表
    'access_table'              => 'access',
);
\houdunwang\config\Config::set( 'rbac', $config );
```

##操作
####登录判断
```
\houdunwang\rbac\Rbac::isLogin();
```

####验证权限
```
\houdunwang\rbac\Rbac::verify();
```

####获取所有
```
\houdunwang\rbac\Rbac::getUserNode(1);
//获取id为1的用户的权限节点
```

####获取用户所有角色名称
```
\houdunwang\rbac\Rbac::getRoleName(100);
//获取id为100的用户所有角色名称
```

####获取系统所有节点信息，以层级显示
```
\houdunwang\rbac\Rbac::getLevelNode();
```

####判断超级管理员
```
\houdunwang\rbac\Rbac::isSuperUser();
```