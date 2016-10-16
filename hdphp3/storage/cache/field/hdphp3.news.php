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
  'title' => 
  array (
    'field' => 'title',
    'type' => 'varchar(100)',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'click' => 
  array (
    'field' => 'click',
    'type' => 'int(11)',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'author' => 
  array (
    'field' => 'author',
    'type' => 'varchar(20)',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'uid' => 
  array (
    'field' => 'uid',
    'type' => 'int(11)',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
);
?>