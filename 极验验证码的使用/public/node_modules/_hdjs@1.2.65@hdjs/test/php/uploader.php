<?php
include '../vendor/autoload.php';
\houdunwang\config\Config::set('upload', [
    'mold' => 'local',
    'type' => 'jpg,jpeg,gif,png,zip,rar,doc,txt,pem,xml,php',
    'size' => 1000000,
    'path' => 'attachment/'.date('Y/m/d'),
]);
$file = \houdunwang\file\File::path('attachment')->upload();
if ($file) {
    $json = ['valid' => 1, 'message' => 'php/'.$file[0]['path']];
} else {
    $json = ['valid' => 0, 'message' => \houdunwang\file\File::getError()];
}
die(json_encode($json));