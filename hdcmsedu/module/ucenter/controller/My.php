<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module\ucenter\controller;

use system\model\Member;
use system\model\Message;
use houdunwang\request\Request;
use Session;
use View;
/**
 * 会员资料管理
 * Class My
 *
 * @package module\ucenter\controller
 */
class My extends Auth
{
    /**
     * 修改会员信息
     *
     * @return mixed|string
     */
    public function info()
    {
        if (IS_POST) {
            $model = Member::find(v('member.info.uid'));
            if ($model->save(Request::post())) {
                return message('会员资料修改成功', 'back', 'success');
            }
        }
        View::with('user', v('member.info'));

        return $this->view($this->template.'/my_info');
    }

    /**
     * 绑定邮箱
     *
     * @param \system\model\Message $message
     *
     * @return array
     */
    public function mail(Message $message)
    {
        //发送验证码
        if (Request::get('sendCode')) {
            $user = Request::post('username');
            if (Member::where('uid', '<>', v('member.info.uid'))->where('siteid', siteid())->where('email', $user)->first()) {
                return ['valid' => 0, 'message' => "{$user} 邮箱已经被其他帐号使用"];
            }

            return $message->sendCode(['user' => $user]);
        }
        if (IS_POST) {
            $codeData = ['code' => Request::post('code'), 'user' => Request::post('email')];
            if ( ! $message->checkCode($codeData)) {
                return ['valid' => 0, 'message' => '验证码错误'];
            }
            $model                = Member::find(v('member.info.uid'));
            $model['email_valid'] = 1;
            $model['email']       = Request::post('email');
            if ($model->save()) {
                return ['valid' => 1, 'message' => '邮箱绑定成功'];
            }
        }
        View::with('user', v('member.info'));
        View::with('validTime', Message::sendDiffTime());

        return $this->view($this->template.'/my_mail');
    }

    /**
     * 绑定会员手机号
     *
     * @param \system\model\Message $message
     *
     * @return array
     */
    public function mobile(Message $message)
    {
        //发送验证码
        if (Request::get('sendCode')) {
            $user = Request::post('username');
            if (Member::where('uid', '<>', v('member.info.uid'))->where('siteid', siteid())->where('mobile', $user)->first()) {
                return ['valid' => 0, 'message' => "{$user} 手机号已经被其他帐号使用"];
            }

            return $message->sendCode(['user' => $user]);
        }
        if (IS_POST) {
            $codeData = ['code' => Request::post('code'), 'user' => Request::post('mobile')];
            if ( ! $message->checkCode($codeData)) {
                return ['valid' => 0, 'message' => '验证码错误'];
            }
            $model                 = Member::find(v('member.info.uid'));
            $model['mobile_valid'] = 1;
            $model['mobile']       = Request::post('mobile');
            if ($model->save()) {
                return ['valid' => 1, 'message' => '手机号绑定成功'];
            }
        }

        View::with('user', v('member.info'));
        View::with('validTime', Message::sendDiffTime());

        return $this->view($this->template.'/my_mobile');
    }

    /**
     * 修改密码
     *
     * @return string
     */
    public function password()
    {
        if (IS_POST) {
            $member = Member::find(v('member.info.uid'));
            if ( ! $member->checkPassword(Request::post('rpassword'))) {
                return message('原密码输入错误', '', 'error');
            }
            $status = $member->changePassword(['password' => Request::post('password'), 'cpassword' => Request::post('cpassword')]);
            if ( ! $status) {
                return message($member->getError(), '', 'info');
            }

            return message('密码修改成功');
        }

        return $this->view($this->template.'/my_password');
    }
}