<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace system\model;

/**
 * 卡券使用模块
 * Class TicketModule
 *
 * @package system\model
 */
class TicketModule extends Common
{
    protected $table = 'ticket_module';
    protected $validate
        = [
            ['tid', 'required', '卡券tid不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['module', 'required', '模块不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
        ];
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
        ];
}