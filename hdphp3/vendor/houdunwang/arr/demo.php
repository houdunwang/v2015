<?php
require 'vendor/autoload.php';

$hd = new \houdunwang\zip\PclZip();
$hd->PclZip('abc.zip');
$hd->create('vendor');