<?php
$fields = array('text'=>'单行文本',
				'textarea'=>'多行文本',
				'editor'=>'编辑器',
				'box'=>'选项',
				'image'=>'图片',
				'images'=>'多图片',
				'number'=>'数字',
				'datetime'=>'日期和时间',
				'linkage'=>'联动菜单',
				);
//不允许删除的字段，这些字段讲不会在字段添加处显示
$not_allow_fields = array('catid','typeid','title','keyword','posid','template','username');
//允许添加但必须唯一的字段
$unique_fields = array('pages','readpoint','author','copyfrom','islink');
//禁止被禁用的字段列表
$forbid_fields = array('catid','title','updatetime','inputtime','url','listorder','status','template','username');
//禁止被删除的字段列表
$forbid_delete = array('catid','typeid','title','thumb','keywords','updatetime','inputtime','posids','url','listorder','status','template','username');
//可以追加 JS和CSS 的字段
$att_css_js = array('text','textarea','box','number','keyword','typeid');
?>