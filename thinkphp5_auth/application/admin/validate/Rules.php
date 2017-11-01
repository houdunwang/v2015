<?php

namespace app\admin\validate;
use think\Validate;

class Rules extends Validate
{
	protected $rule = [
		'title'=>'require',
		'name'=>'require',
		'nav'=>'require'
	];
	protected $message = [
		'title.require'=>'请输入规则中文名称',
		'name.require'=>'请输入规则标识',
		'nav.require'=>'请输入导航菜单'
	];
}