<?php
include '../vendor/autoload.php';
\houdunwang\config\Config::loadFiles(__DIR__.'/config');
echo \houdunwang\oss\Oss::sign();