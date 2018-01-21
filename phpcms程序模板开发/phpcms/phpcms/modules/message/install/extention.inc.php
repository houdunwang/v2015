<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'message', 'parentid'=>29, 'm'=>'message', 'c'=>'message', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'send_one', 'parentid'=>$parentid, 'm'=>'message', 'c'=>'message', 'a'=>'send_one', 'data'=>'', 'listorder'=>0, 'display'=>'1'));
$menu_db->insert(array('name'=>'delete_message', 'parentid'=>$parentid, 'm'=>'message', 'c'=>'message', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'message_send', 'parentid'=>$parentid, 'm'=>'message', 'c'=>'message', 'a'=>'message_send', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'message_group_manage', 'parentid'=>$parentid, 'm'=>'message', 'c'=>'message', 'a'=>'message_group_manage', 'data'=>'', 'listorder'=>0, 'display'=>'1'));

$language = array('message'=>'短消息', 'send_one'=>'发送消息', 'delete_message'=>'删除短消息', 'message_send'=>'群发短消息', 'message_group_manage'=>'群发短消息管理');
?>