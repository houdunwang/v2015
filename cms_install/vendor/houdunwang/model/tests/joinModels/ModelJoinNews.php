<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace tests\joinModels;

use houdunwang\model\Model;

class ModelJoinNews extends Model
{
    protected $timestamps = true;

    public function user()
    {
        return $this->belongsTo(ModelJoinUser::class, 'user_id', 'id');
    }
}