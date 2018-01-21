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
 * 站点配置管理
 * Class SiteSetting
 *
 * @package system\model
 */
class SiteSetting extends Common
{
    protected $table = 'site_setting';

    protected $allowFill = ['*'];

    protected $validate = [];

    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['grouplevel', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['default_template', 1, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['welcome', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['default_message', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
        ];

    /**
     * 获取站点可用的积分类型
     *
     * @return array
     */
    public static function creditLists()
    {
        $data = [];
        foreach (v('site.setting.creditnames') as $name => $v) {
            if ($v['status'] == 1) {
                $v['name']   = $name;
                $data[$name] = $v;
            }
        }

        return $data;
    }
}