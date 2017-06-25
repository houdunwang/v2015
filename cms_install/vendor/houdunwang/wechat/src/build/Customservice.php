<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace houdunwang\wechat\build;

use houdunwang\wechat\build\customservice\CustomManage;
use houdunwang\wechat\build\customservice\CustomMessage;

/**
 * 客服接口
 * Class CustomerService
 *
 * @package houdunwang\wechat\build
 */
class CustomService extends Base
{
    use CustomManage, CustomMessage;
}