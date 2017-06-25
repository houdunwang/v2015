<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace tests\models;

use houdunwang\model\Model;

class ModelValidate extends Model
{
    protected $validate
        = [
            [
                'username',
                'required',
                '用户名不能为空',
                self::MUST_VALIDATE,
                self::MODEL_BOTH,
            ],
            [
                'age',
                '/^\d+$/',
                '年龄必须是数字',
                self::MUST_VALIDATE,
                self::MODEL_BOTH,
            ],
            [
                'username',
                'unique',
                '用户已存在',
                self::MUST_VALIDATE,
                self::MODEL_BOTH,
            ],
            [
                'username',
                'checkUserName',
                '长度不对哟',
                self::MUST_VALIDATE,
                self::MODEL_BOTH,
            ],
        ];

    public function checkUserName($field, $value, $params, $data)
    {
        //返回true，为验证通过
        if (mb_strlen($value, 'utf-8') > 5) {
            return true;
        }
    }
}