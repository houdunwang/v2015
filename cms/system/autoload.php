<?php
/*--------------------------------------------------------------------------
| PHP版本检测
|--------------------------------------------------------------------------*/
define('HDPHP_START', microtime(true));
if (version_compare(phpversion(), '5.4.0', '<')) {
    die('<h1 style=\'margin:20px;color:#535353;font:36px/1.5 Helvetica, Arial\'><span style="font-size:150px;">:( </span><br/>Please upgrade to PHP5.4 above</h1>');
}
require __DIR__.'/../vendor/autoload.php';