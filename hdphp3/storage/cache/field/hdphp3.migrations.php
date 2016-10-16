<?php if(!defined('ROOT_PATH'))exit;
return array (
  'migration' => 
  array (
    'field' => 'migration',
    'type' => 'varchar(255)',
    'null' => 'NO',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
  'batch' => 
  array (
    'field' => 'batch',
    'type' => 'int(11)',
    'null' => 'YES',
    'key' => false,
    'default' => NULL,
    'extra' => '',
  ),
);
?>