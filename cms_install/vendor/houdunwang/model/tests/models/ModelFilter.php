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

class ModelFilter extends Model
{
    protected $filter
        = [
            //当密码为空时，从更新或添加数据中删除密码字段
            ['title', self::MUST_FILTER, self::MODEL_BOTH],
        ];
}