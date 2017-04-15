<?php

namespace app\admin\validate;
use think\Validate;

class Link extends Validate
{
	protected $rule = [
		'link_name'=>'require',
		'link_url'=>'require',
		'link_sort'=>'require|between:1,9999',
	];
	protected $message = [
		'link_name.require'=>'请输入友链名称',
		'link_url.require'=>'请输入友链地址',
		'link_sort.require'=>'请输入友链排序',
		'link_sort.between'=>'友链排序需在1-9999之间',
	];
}