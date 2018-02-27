<?php
/*--------------------------------------------------------------------------
| 路由规则设置
|--------------------------------------------------------------------------
| 框架支持路由访问机制与普通GET方式访问
| 如果使用普通GET方式访问时不需要设置路由规则
| 当然也可以根据业务需要两种方式都使用
|-------------------------------------------------------------------------*/

//更新HDCMS
Route::get('update', 'app\system\controller\Cloud@localUpdate');

//后台管理员登录
Route::get(
    'login',
    function () {
        return go(web_url().'?m=ucenter&action=controller/entry/login');
    }
);

//后台管理员登录
Route::get(
    'register',
    function () {
        return go(web_url().'?m=ucenter&action=controller/entry/register');
    }
);

//会员中心
Route::get(
    'member',
    function () {
        return go(web_url().'?m=ucenter&action=controller/member/index');
    }
);

/**
 * 后台管理员登录
 * 会显示站点列表
 */
Route::any(
    'hdcms',
    function () {
        \houdunwang\session\Session::set('system.login', 'hdcms');

        return action(\app\system\controller\Entry::class, 'login');
    }
);

/**
 * 站点管理员登录
 * 站点管理员登录后直接登录到站点管理平台
 * 不显示系统管理界面
 */
Route::any(
    'admin',
    function () {
        \houdunwang\session\Session::set('system.login', 'admin');

        return action(\app\system\controller\Entry::class, 'login');
    }
);

/**
 * 文章模块路由规则
 */
Route::get('article{siteid}-{aid}-{cid}-{mid}.html', 'module\article\controller\Entry@content');
Route::get('article{siteid}-{cid}-{page}.html', 'module\article\controller\Entry@category');

/*
|--------------------------------------------------------------------------
| 支付宝通知地址
|--------------------------------------------------------------------------
*/
//同步
Route::any('alipay/sync/{m}/{siteid}', 'app\pay\controller\AliPay@sync');
//异步
Route::any('alipay/async/{m}/{siteid}', 'app\pay\controller\AliPay@async');


//微信支付异步通知地址
Route::any('wechat/async/{m}/{siteid}', 'app\pay\controller\WeChat@async');
