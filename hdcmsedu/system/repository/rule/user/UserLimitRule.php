<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace system\repository\rule\user;

use houdunwang\model\repository\Repository;
use houdunwang\model\repository\Rule;


class UserLimitRule extends Rule
{
    protected $limit;

    public function __construct($limit = 10)
    {
        $this->limit = $limit;
    }

    public function apply($model, Repository $repository)
    {
        return $model->limit($this->limit)->where('uid', 0);
    }

}