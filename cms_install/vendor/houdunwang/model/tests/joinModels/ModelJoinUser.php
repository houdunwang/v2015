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

class ModelJoinUser extends Model
{
    protected $timestamps = true;

    public function address()
    {
        return $this->hasOne(ModelJoinAddress::class, 'user_id');
    }

    public function news()
    {
        return $this->hasMany(ModelJoinNews::class, 'user_id');
    }

    public function group()
    {
        return $this->belongsToMany(ModelJoinGroup::class,'model_join_user_group','user_id','group_id');
    }
}