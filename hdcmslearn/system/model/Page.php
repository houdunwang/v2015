<?php namespace system\model;

/**
 * 微官网页面(快捷导航/专题页面)
 * Class Page
 *
 * @package system\model
 */
class Page extends Common
{
    protected $table = 'page';

    protected $allowFill = ['*'];

    protected $validate
        = [
            ['title', 'required', '标题不能为空', self::EXIST_VALIDATE, self::MODEL_BOTH],
            ['type', 'required', '页面类型不能为空.quickmenu快捷导航 profile会员中心', self::MUST_VALIDATE, self::MODEL_INSERT],
        ];
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::MUST_AUTO, self::MODEL_BOTH],
            ['description', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['params', 'json_encode', 'function', self::MUST_AUTO, self::MODEL_BOTH],
            ['html', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['status', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['status', 'intval', 'intval', self::NOT_EXIST_AUTO, self::MODEL_BOTH],
            ['createtime', 'time', 'function', self::MUST_AUTO, self::MODEL_INSERT],
            ['webid', 0, 'string', self::MUST_AUTO, self::MODEL_INSERT],
        ];

    /**
     * 获取页面数据
     *
     * @param string $type 页面类型
     * @param string $default
     *
     * @return json
     */
    public function getParamsByType($type, $default = '{}')
    {
        return self::where('siteid', siteid())->where('type', $type)->pluck('params') ?: $default;
    }
}