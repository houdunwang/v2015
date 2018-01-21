<?php
define('RUN_MODE', 'HTTP');
$msg = '';
if (version_compare(phpversion(), '5.6.0', '<')) {
    $msg .= 'Please upgrade to PHP5.6 above<br/>';
}

if ( ! function_exists('openssl_encrypt')) {
    $msg .= 'Extension php_openssl is not open<br/>';
}
if ($msg) {
    die("<h1 style='margin:20px;color:#535353;font:36px/1.5 Helvetica, Arial'>
        <span style='font-size:150px;'>:(</span><br/>{$msg}</h1>");
}
require __DIR__ . '/autoload.php';
\houdunwang\framework\App::bootstrap();