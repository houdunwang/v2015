<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module\ucenter\controller;

use houdunwang\wechat\WeChat;
use Request;
use Session;
use module\HdController;
use system\model\Member;
use system\model\Message;

/**
 * 会员登录注册管理
 * Class Entry
 *
 * @package module\ucenter\controller
 */
class Entry extends HdController
{
    /**
     * 构造函数
     * Entry constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->template = UCENTER_TEMPLATE_PATH;
    }

    /**
     * 找回密码
     *
     * @param \system\model\Member  $Member
     * @param \system\model\Message $message
     *
     * @return array|bool
     */
    public function forgetpwd(Member $Member, Message $message)
    {
        if (IS_POST) {
            //开启验证码验证时进行验证码发送
            $codeData = ['code' => Request::post('valid_code'), 'user' => Request::post('username')];
            if ( ! $message->checkCode($codeData)) {
                return ['valid' => 0, 'message' => '验证码错误'];
            }

            if ($user = $Member->getUserByName(Request::post('username'))) {
                if ($user->changePassword(Request::post()) === false) {
                    return message($user->getError(), '', 'error');
                }

                return message('密码修改成功');
            }

            return message('帐号不存在', '', 'error');
        }
        $placeholder = [
            0 => '登录暂时关闭',
            1 => '手机号',
            2 => '邮箱',
            3 => '手机号或邮箱',
        ];
        View::with('placeholder', $placeholder[v('site.setting.login.type')]);

        return View::make($this->template.'/forgetpwd');
    }

    /**
     * 发送找回密码验证码
     *
     * @param \system\model\Message $message
     * @param \system\model\Member  $Member
     *
     * @return array
     */
    public function sendForgetPwdValidCode(Message $message, Member $Member)
    {
        $user = Request::post('username');
        //检测帐号是否已经注册
        if ( ! $Member->getUserByName($user)) {
            return ['message' => '帐号不存在', 'valid' => 0];
        }
        if (preg_match('/^\d{11}$/', $user) && in_array(v('site.setting.register.type'), [1, 3])) {
            return $message->sendCode(['user' => $user]);
        }
        if (preg_match('/\w+@\w+/', $user) && in_array(v('site.setting.register.type'), [2, 3])) {
            return $message->sendCode(['user' => $user]);
        }

        return ['message' => '帐号格式错误', 'valid' => 0];
    }

    /**
     * 注册页面
     * @param \system\model\Member  $Member
     * @param \system\model\Message $message
     *
     * @return array|string
     * @throws \Exception
     */
    public function register(Member $Member, Message $message)
    {
        if (IS_POST) {
            $codeData = ['code' => Request::post('valid_code'), 'user' => Request::post('username')];
            if (v('site.setting.register.auth') && ! $message->checkCode($codeData)) {
                return ['valid' => 0, 'message' => '验证码错误'];
            }

            return $Member->register(Request::post());
        }
        $placeholder = [
            0 => '网站关闭注册',
            1 => '手机号',
            2 => '邮箱',
            3 => '手机号或邮箱',
        ];
        View::with('placeholder', $placeholder[v('site.setting.register.type')]);

        return $this->view($this->template.'/register');
    }

    /**
     * 发送注册验证码
     *
     * @param \system\model\Message $message
     * @param \system\model\Member  $Member
     *
     * @return array
     */
    public function sendRegisterValidCode(Message $message, Member $Member)
    {
        $user = Request::post('username');
        //检测帐号是否已经注册
        if ($Member->getUserByName($user)) {
            return ['message' => '帐号已经注册过', 'valid' => 0];
        }
        if (preg_match('/^\d{11}$/', $user) && in_array(v('site.setting.register.type'), [1, 3])) {
            return $message->sendCode(['user' => $user]);
        }
        if (preg_match('/\w+@\w+/', $user) && in_array(v('site.setting.register.type'), [2, 3])) {
            return $message->sendCode(['user' => $user]);
        }

        return ['message' => '帐号格式错误', 'valid' => 0];
    }

    /**
     * 会员登录
     *
     * @return array|bool|mixed|string
     */
    public function login()
    {
        if (memberIsLogin(true) == true) {
            return $this->fromUrl;
        }

        if (IS_POST) {
            return Member::login(Request::post());
        }
        $placeholder = [
            0 => '登录暂时关闭',
            1 => '手机号',
            2 => '邮箱',
            3 => '手机号或邮箱',
        ];
        View::with('placeholder', $placeholder[v('site.setting.login.type')]);

        return $this->view($this->template.'/login', ['url' => $this->fromUrl]);
    }

    /**
     * 微信登录
     *
     * @param \system\model\Member $member
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function wechatLogin(Member $member)
    {
        $res = $member->weChatLogin();
        if ($res === true) {
            return url('member.index', [], 'ucenter');
        }

        return message($res, '', 'info');
    }

    /**
     * 使用历史记录跳转
     *
     * @return string
     */
    protected function redirect()
    {
        Session::del('from');

        return go($this->fromUrl);
    }

    /**
     * 退出登录
     *
     * @return string
     */
    public function out()
    {
        Session::del('member_uid');

        return __ROOT__;
    }
}