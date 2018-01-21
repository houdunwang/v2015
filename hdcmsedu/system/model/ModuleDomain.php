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
 * 模块域名管理
 * Class ModuleDomain
 *
 * @package system\model
 */
class ModuleDomain extends Common
{
    protected $table = 'module_domain';
    protected $denyInsertFields = ['id'];
    protected $validate
        = [
            ['domain', 'required', '域名不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['module', 'required:10', '模块标识不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
        ];
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_INSERT],
        ];
}