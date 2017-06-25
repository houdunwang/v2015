<?php
\houdunwang\route\Route::get('/', function () {
    return 'root';
});

\houdunwang\route\Route::get('show', function () {
    return 'Hello HDPHP';
});

\houdunwang\route\Route::get('show/a/{id}', function () {
    return 'Hello HDPHP';
});

\houdunwang\route\Route::get('user/{id}/{name?}', function ($id, $name) {
    return $id.'-'.$name;
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);

\houdunwang\route\Route::post('user/add', function () {
    return \houdunwang\request\Request::post('user');
});

\houdunwang\route\Route::put('user/put', function () {
    return \houdunwang\request\Request::post('user');
});

\houdunwang\route\Route::delete('user/delete', function () {
    return \houdunwang\request\Request::post('user');
});

\houdunwang\route\Route::any('any', function () {
    return 'any';
});

\houdunwang\route\Route::get('getUserId/{id}', function ($id) {
    return $id;
});


\houdunwang\route\Route::get('userInfo/{name?}', function ($name = '后盾网') {
    return $name;
});

\houdunwang\route\Route::get('args/all/{id}-{name}', function () {
    return \houdunwang\route\Route::input();
});

\houdunwang\route\Route::get('{name}', function ($name) {
    return $name;
});

\houdunwang\route\Route::get('ioc/{id}/{name}',
    function ($id, $f = '后盾人', \tests\app\NewsModel $a, $name) {
        return $id.$f.$name;
    }
);