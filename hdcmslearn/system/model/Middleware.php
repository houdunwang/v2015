<?php namespace system\model;

/**
 * 模块中间件
 * Class Middleware
 *
 * @package system\model
 */
class Middleware extends Common
{
    protected $table = 'middleware';

    protected $allowFill = ['*'];

    protected $validate
        = [
            ['title', 'required', '操作描述不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
        ];

    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['status', 1, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
        ];
}