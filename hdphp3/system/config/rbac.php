<?php
return [
	//1时时认证｜2登录认证
	'type'           => 1,
	//站长名称（站长不需要验证）
	'super_user'     => 'admin',
	//用户名字段
	'username_field' => 'username',
	//密码字段
	'password_field' => 'password',
	//用户SESSION名
	'auth_key'       => 'id',
	//不需要验证请求: array('Admin.User.add')
	//Admin模块 User控制器 add动作 不需要验证
	'no_auth'         => [ ],
	//用户角色表
	'user_table'      => 'user',
	//角色表
	'role_table'      => 'role',
	//节点表
	'node_table'      => 'node',
	//角色与用户关联表
	'user_role_table' => 'user_role',
	//权限分配表
	'access_table'    => 'access',
];