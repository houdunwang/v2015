<?php
require '../../vendor/autoload.php';
include __DIR__.'/routes/restful.php';
include __DIR__.'/routes/group.php';
include __DIR__.'/routes/controller.php';
include __DIR__.'/routes/routes.php';
\houdunwang\config\Config::loadFiles('config');
\houdunwang\route\Route::bootstrap();
echo \houdunwang\route\Route::getContent();