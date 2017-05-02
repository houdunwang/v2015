<?php
require 'vendor/autoload.php';
$obj = new \houdunwang\response\Response();
$obj->sendHttpStatus(404);
$obj->ajax(['name'=>'后盾网'],'xml');