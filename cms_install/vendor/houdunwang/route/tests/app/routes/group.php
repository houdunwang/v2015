<?php
//控制器路由
\houdunwang\route\Route::group(['prefix' => 'admin'], function () {
    \houdunwang\route\Route::get('add', function () {
        return 'add';
    });
    \houdunwang\route\Route::get('save', function () {
        return 'save';
    });
});