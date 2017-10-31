<?php

require_once 'config.php';
require_once 'saetv2.ex.class.php';

$code = $_GET['code'];

$wb = new SaeTOAuthV2(WB_APP,WB_SECRET);
$keys = [
    'code' => $code,
    'redirect_uri' => 'test.liyalong.hdphp.com/callback.php',
];
$auth = $wb->getAccessToken($keys);
setcookie('access_token',$auth['access_token'],time() + 60*60);
header('Location:index.php');



