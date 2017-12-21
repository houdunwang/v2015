<?php
defined('IN_ADMIN') or exit('No permission resources.');

$field_type				= 'varchar'; //字段数据库类型	
$field_basic_table		= 1; //是否允许作为主表字段
$field_allow_index		= 1; //是否允许建立索引
$field_minlength		= 0; //字符长度默认最小值
$field_maxlength		= ''; //字符长度默认最大值
$field_allow_search		= 1; //作为搜索条件
$field_allow_fulltext	= 1; //作为全站搜索信息
$field_allow_isunique	= 1; //是否允许值唯一
?>