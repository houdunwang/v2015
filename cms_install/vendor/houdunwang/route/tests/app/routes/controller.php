<?php
//控制器路由
\houdunwang\route\Route::get('entry/show.html', 'controller\Entry@show'

);
\houdunwang\route\Route::controller('entry', "controller\Entry");