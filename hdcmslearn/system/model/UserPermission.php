<?php namespace system\model;

/**
 * 用户站点操作权限
 * Class UserPermission
 *
 * @package system\model
 */
class UserPermission extends Common
{
    protected $table = 'user_permission';
    protected $validate
        = [
            ['uid', 'required', '用户编号不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['siteid', 'required', '站点编号不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['type', 'required', '模块类型不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['permission', 'required', '权限内容不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
        ];
}