<?php
defined('IN_PHPCMS') or exit('No permission resources.');
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    $modules[$i]['code']    = basename(__FILE__, '.class.php');
    $modules[$i]['name']    = L('bank_transfer', '', 'pay');   
    $modules[$i]['desc']    = L('transfer', '', 'pay');
    $modules[$i]['is_cod']  = '0';
    $modules[$i]['is_online']  = '0';
    $modules[$i]['author']  = 'PHPCMS开发团队';
    $modules[$i]['website'] = '';
    $modules[$i]['version'] = '1.0.0';
    $modules[$i]['config']  = array();
    return;
}
?>