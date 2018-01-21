<?php
defined('IN_PHPCMS') or exit('Access Denied');
defined('INSTALL') or exit('Access Denied');
$parentid = $menu_db->insert(array('name'=>'mood', 'parentid'=>'29', 'm'=>'mood', 'c'=>'mood_admin', 'a'=>'init', 'data'=>'', 'listorder'=>0, 'display'=>'1'), true);
$menu_db->insert(array('name'=>'mood_setting', 'parentid'=>$parentid, 'm'=>'mood', 'c'=>'mood_admin', 'a'=>'setting', 'data'=>'', 'listorder'=>0, 'display'=>'1'));

$language = array('mood'=>'新闻心情', 'mood_setting'=>'心情配置');
setcache('mood_program', array('1'=>array(
  1 => 
  array (
    'use' => '1',
    'name' => '震惊',
    'pic' => 'mood/a1.gif',
  ),
  2 => 
  array (
    'use' => '1',
    'name' => '不解',
    'pic' => 'mood/a2.gif',
  ),
  3 => 
  array (
    'use' => '1',
    'name' => '愤怒',
    'pic' => 'mood/a3.gif',
  ),
  4 => 
  array (
    'use' => '1',
    'name' => '杯具',
    'pic' => 'mood/a4.gif',
  ),
  5 => 
  array (
    'use' => '1',
    'name' => '无聊',
    'pic' => 'mood/a5.gif',
  ),
  6 => 
  array (
    'use' => '1',
    'name' => '高兴',
    'pic' => 'mood/a6.gif',
  ),
  7 => 
  array (
    'use' => '1',
    'name' => '支持',
    'pic' => 'mood/a7.gif',
  ),
  8 => 
  array (
    'use' => '1',
    'name' => '超赞',
    'pic' => 'mood/a8.gif',
  ),
  9 => 
  array (
    'use' => NULL,
    'name' => '',
    'pic' => '',
  ),
  10 => 
  array (
    'use' => NULL,
    'name' => '',
    'pic' => '',
  ),
)), 'commons');
?>