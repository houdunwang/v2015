<?php

namespace system\request;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
use houdunwang\request\build\FormRequest;
use houdunwang\validate\Validate;

/**
 * 用户
 * Class UserRequest
 *
 * @package system\request
 */
class UserRequest extends FormRequest
{
    /**
     * 权限验证
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * 验证规则
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'required', '帐号不能为空', Validate::MUST_VALIDATE],
            ['password', 'required', '密码不能为空', Validate::EXISTS_VALIDATE],
            ['code', 'captcha', '验证码输入错误', Validate::EXISTS_VALIDATE],
        ];
    }
}