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
 * Class UserRequest
 *
 * @package system\request
 */
class {{NAME}} extends FormRequest
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
     * 验证规则的使用请参数"自动验证"组件
     * @return array
     */
    public function rules()
    {
        return [];
    }
}