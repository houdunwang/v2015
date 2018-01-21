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
            ['uid', 'isnull', '用户编号不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['siteid', 'isnull', '站点编号不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['type', 'isnull', '模块类型不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['permission', 'isnull', '权限内容不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
        ];
}