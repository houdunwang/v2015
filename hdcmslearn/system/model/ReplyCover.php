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
 * 封面回复
 * Class ReplyCover
 *
 * @package system\model
 */
class ReplyCover extends Common
{
    protected $table = 'reply_cover';
    protected $allowFill = ['*'];
    protected $validate
        = [
            ['rid', 'required', '回复规则编号不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['title', 'required', '封面回复标题不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['description', 'required', '描述不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
            ['thumb', 'required', '图片不能为空', self::MUST_VALIDATE, self::MODEL_BOTH],
        ];
    protected $auto
        = [
            ['siteid', 'siteid', 'function', self::EMPTY_AUTO, self::MODEL_BOTH],
            ['web_id', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['module', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['do', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['url', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
        ];

    /**
     * 获取模块的封面回复
     *
     * @param string $module 模块标识
     * @param string $do     动作
     *
     * @return mixed
     */
    public function getModuleCover($module, $do)
    {
        $url = '?m='.v('module.name').'&action=system/cover/'.$do;

        return self::where('siteid', siteid())->where('module', $module)->where('url', $url)->first();
    }

    /**
     * 模块封面回复链接
     *
     * @param string $module 模块标识
     * @param string $do     执行动作
     *
     * @return string
     */
    public function getModuleCoverUrl($module, $do)
    {
        return '?m='.$module.'&action=system/cover/'.$do;
    }
}