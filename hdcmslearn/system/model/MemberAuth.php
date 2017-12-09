<?php namespace system\model;

/**
 * 会员授权登录
 * Class MemberAuth
 *
 * @package system\model
 */
class MemberAuth extends Common
{
    protected $table = 'member_auth';

    protected $allowFill = ['*'];

    protected $validate
        = [
            ['uid', 'required', '会员编号不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
        ];
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['qq', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['wechat', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['weibo', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
        ];
}