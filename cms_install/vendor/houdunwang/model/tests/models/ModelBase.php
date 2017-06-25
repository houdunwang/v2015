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

class ModelBase extends Model
{
    protected $timestamps = true;
    protected $auto
        = [
            //更新时对 addtime 字段执行strtotime函数
            ['click', 100, 'string', self::MUST_AUTO, self::MODEL_BOTH],
            [
                'addtime',
                'time',
                'function',
                self::MUST_AUTO,
                self::MODEL_INSERT,
            ],
        ];
}