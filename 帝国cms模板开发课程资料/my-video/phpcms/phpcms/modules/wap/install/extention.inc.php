<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');

$parentid = $menu_db->insert(array('name'=>'wap', 'parentid'=>29, 'm'=>'wap', 'c'=>'wap_admin', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'wap_add', 'parentid'=>$parentid, 'm'=>'wap', 'c'=>'wap_admin', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'wap_edit', 'parentid'=>$parentid, 'm'=>'wap', 'c'=>'wap_admin', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'wap_delete', 'parentid'=>$parentid, 'm'=>'wap', 'c'=>'wap_admin', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'wap_type_manage', 'parentid'=>$parentid, 'm'=>'wap', 'c'=>'wap_admin', 'a'=>'type_manage', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'wap_type_edit', 'parentid'=>$parentid, 'm'=>'wap', 'c'=>'wap_admin', 'a'=>'type_edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'wap_type_delete', 'parentid'=>$parentid, 'm'=>'wap', 'c'=>'wap_admin', 'a'=>'type_delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$language = array('wap'=>'手机门户','wap_add'=>'添加','wap_edit'=>'修改','wap_delete'=>'删除','wap_type_manage'=>'分类管理','wap_type_edit'=>'分类编辑','wap_type_delete'=>'分类删除',);
?>