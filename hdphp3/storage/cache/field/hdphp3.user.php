<?php if(!defined('ROOT_PATH'))exit;
return array (
  'id' => 
  array (
    'field' => 'id',
    'type' => 'int(11) unsigned',
    'null' => 'NO',
    'key' => true,
    'default' => NULL,
    'extra' => 'auto_increment',
  ),
  'username' => 
  array (
    'field' => 'username',
    'type' => 'char(20)',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
);
?>