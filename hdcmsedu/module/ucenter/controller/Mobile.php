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

use houdunwang\validate\Validate;
use system\model\Member;

/**
 * 修改手机号
 * Class Mobile
 *
 * @package module\ucenter\controller
 */
class Mobile extends Auth
{
    /**
     * 修改手机号
     */
    public function changeMobile()
    {
        if (IS_POST) {
            Validate::make([
                ['mobile', 'required|phone', '手机号输入错误', Validate::MUST_VALIDATE],
            ]);
            if (Member::where('mobile', Request::post('mobile'))->where('uid', '<>', v('member.info.mobile'))->get()) {
                return message('手机号已经被使用', 'back', 'error');
            }
            $model           = Member::find(v('member.info.uid'));
            $model['mobile'] = Request::post('mobile');
            if ($d = $model->save()) {
                //更新用户session
                return message('手机号更新成功', url('member.index'), 'success');
            }

            return message($this->db->getError(), 'back', 'error');
        }

        return View::make($this->template.'/change_mobile');
    }
}