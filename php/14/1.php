<?php
//值
//$a = 'hdcms.com';
//$b = $a;
//$b = 'hdphp.com';
//echo $a;

$a = 'hdcms.com';
$b = &$a;
$b = 'hdphp.com';
echo $a;