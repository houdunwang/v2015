<?php
//常量
define('HDPHP_VERSION', '2020');
echo HDPHP_VERSION;
//define('HDPHP_VERSION','2029');

function call()
{
    $a='hdphp';
    define('A','hdcms');
    echo $a;
}
call();
echo $a;
echo A;