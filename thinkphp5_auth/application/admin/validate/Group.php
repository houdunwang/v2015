<?php

namespace app\admin\validate;
use think\Validate;

class Group extends Validate
{
	protected $rule = [
		'title'=>'require',
		'rules'=>'require',
	];
	protected $message = [
		'title.require'=>'请输入用户组名称',
		'rules.require'=>'请选择规则',
	];
}