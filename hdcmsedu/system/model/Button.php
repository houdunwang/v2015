<?php namespace system\model;

/**
 * 微信菜单管理
 * Class Button
 *
 * @package system\model
 * @author  向军
 */
class Button extends Common
{
    protected $table = 'button';
    protected $timestamps = true;
    protected $validate
        = [
            ['title', 'required', '标题不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],

        ];
    protected $auto
        = [
            ['createtime', 'time', 'function', self::MUST_AUTO, self::MODEL_BOTH],
            ['status', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
        ];
}