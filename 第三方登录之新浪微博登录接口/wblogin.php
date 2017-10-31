<?php

require_once 'config.php';
require_once 'saetv2.ex.class.php';

$wb = new SaeTOAuthV2(WB_APP,WB_SECRET);
$url = 'test.liyalong.hdphp.com/callback.php';
$auth = $wb->getAuthorizeURL($url);
header('Location:' . $auth);