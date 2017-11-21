<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'vote', 'parentid'=>'29', 'm'=>'vote', 'c'=>'vote', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'add_vote', 'parentid'=>$parentid, 'm'=>'vote', 'c'=>'vote', 'a'=>'add', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'edit_vote', 'parentid'=>$parentid, 'm'=>'vote', 'c'=>'vote', 'a'=>'edit', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'delete_vote', 'parentid'=>$parentid, 'm'=>'vote', 'c'=>'vote', 'a'=>'delete', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'vote_setting', 'parentid'=>$parentid, 'm'=>'vote', 'c'=>'vote', 'a'=>'setting', 'data'=>'', 'listorder'=>0, 'display'=>'1'));

$menu_db->insert(array('name'=>'statistics_vote', 'parentid'=>$parentid, 'm'=>'vote', 'c'=>'vote', 'a'=>'statistics', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'statistics_userlist', 'parentid'=>$parentid, 'm'=>'vote', 'c'=>'vote', 'a'=>'statistics_userlist', 'data'=>'', 'listorder'=>0, 'display'=>'0'));
$menu_db->insert(array('name'=>'create_js', 'parentid'=>$parentid, 'm'=>'vote', 'c'=>'vote', 'a'=>'create_js', 'data'=>'', 'listorder'=>0, 'display'=>'1'));

$language = array('vote'=>'投票', 'add_vote'=>'添加投票', 'edit_vote'=>'编辑投票','delete_vote'=>'删除投票', 'vote_setting'=>'投票配置', 'statistics_vote'=>'查看统计', 'statistics_userlist'=>'会员统计','create_js'=>'更新JS');
?>