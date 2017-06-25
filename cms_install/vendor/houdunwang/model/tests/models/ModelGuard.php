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

/**
 * 字段保护
 * Class ModelGuard
 *
 * @package tests\models
 */
class ModelGuard extends Model
{
    protected $allowFill = ['title'];
    //禁止填充字段
    protected $denyFill = ['addtime'];
}