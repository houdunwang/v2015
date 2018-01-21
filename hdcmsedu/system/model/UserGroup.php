<?php namespace system\model;

/**
 * 管理员组
 * Class UserGroup
 *
 * @package system\model
 */
class UserGroup extends Common
{
    protected $table = 'user_group';
    protected $validate
        = [
            ['name', 'required', '用户组名称不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['maxsite', 'num:1,1000', '站点数量不能超过1000', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['middleware_num', 'num:1,1000', '中间件数量不能超过1000', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['maxsite', 'num:1,1000', '路由数量不能超过1000', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['daylimit', 'regexp:/^[1-9]\d*$/', '有效期限只能为数字', self::MUST_VALIDATE, self::MODEL_BOTH],
        ];
    protected $auto
        = [
            ['package', 'json_encode', 'function', self::EXIST_AUTO, self::MODEL_BOTH],
        ];
}