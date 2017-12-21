<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'upgrade', 'parentid'=>977, 'm'=>'upgrade', 'c'=>'index', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'checkfile', 'parentid'=>$parentid, 'm'=>'upgrade', 'c'=>'index', 'a'=>'checkfile', 'data'=>'', 'listorder'=>0, 'display'=>'1'));

$language = array('upgrade'=>'在线升级', 'checkfile'=>'文件校验');
?>