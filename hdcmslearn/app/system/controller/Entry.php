<?php namespace app\system\controller;

use houdunwang\session\Session;
use system\request\UserRequest;
use system\model\User;
use Middleware;

/**
 * 后台登录/退出
 * Class entry
 *
 * @package system\controller
 */
class Entry extends Admin
{
    public function __construct()
    {
        $this->auth(['login', 'quit', 'register']);
    }

    /**
     * 用户注册
     *
     * @param \system\request\UserRequest $request
     *
     * @return mixed
     */
    public function register(UserRequest $request)
    {
        if ( ! v('config.register.is_open')) {
            return message('系统暂时关闭用户注册', '', 'info');
        }
        if (IS_POST) {
            User::register($request());

            return message('注册成功,请登录系统', u('login', ['from' => q('get.form')]));
        }

        return view();
    }

    /**
     * 后台帐号登录
     *
     * @param \system\request\UserRequest $request
     * @param \system\model\User          $user
     *
     * @return mixed
     */
    public function login(UserRequest $request, User $user)
    {
        if (IS_POST) {
            //会员登录
            $message = $user->login($request());
            if ($message !== true) {
                return message($message, '', 'error');
            }
            if (siteid() && Session::get('system.login') == 'admin') {
                $url = web_url(true).'?s=site/entry/home&siteid='.siteid();
            } else {
                $url = u('site.lists');
            }

            return ['message' => '登录成功', 'url' => $url, 'valid' => 1];
        }
        if (User::loginAuth()) {
            return redirect($user->adminEntryPage());
        }

        return view();
    }

    /**
     * 退出登录
     *
     * @param \system\model\User $User
     *
     * @return string
     */
    public function quit(User $User)
    {
        Session::del('admin_uid');

        return $User->getLoginUrl();
    }
}