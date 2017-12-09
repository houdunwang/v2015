<?php
define('RUN_MODE', 'HTTP');
if (version_compare(phpversion(), '5.6.0', '<')) {
    die('<h1 style=\'margin:20px;color:#535353;font:36px/1.5 Helvetica, Arial\'><span style="font-size:150px;">:( </span><br/>Please upgrade to PHP5.6 above</h1>');
}
require __DIR__.'/autoload.php';
\houdunwang\framework\App::bootstrap();