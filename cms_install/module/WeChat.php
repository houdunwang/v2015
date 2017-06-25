<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module;

use Request;
use system\model\Keyword;

/**
 * Trait WeChat
 *
 * @package module
 */
trait WeChat
{
    /**
     * 保存关键词数据
     *
     * @param array $data
     *
     * @return bool
     */
    final protected function saveKeyword(array $data)
    {
        if (empty($data['wechat_keyword'])) {
            return false;
        }
        //关键词所在的模块
        $moduleName         = isset($data['module']) ? $data['module'] : Request::get('m');
        $where              = [
            ['module_id', $data['module_id']],
            ['module', $moduleName],
        ];
        $model              = Keyword::where($where)->first() ?: new Keyword();
        $model['module']    = trim($moduleName);
        $model['content']   = $data['wechat_keyword'];
        $model['module_id'] = $data['module_id'];
        $model->save();
    }

    /**
     * 编辑时分配关键词
     *
     * @param $module_id 模块记录的主键编号
     */
    final protected function assignKeyword($module_id)
    {
        $where   = [
            ['module_id', $module_id],
            ['module', Request::get('m')],
        ];
        $content = Keyword::where($where)->pluck('content');
        View::with('wechat_keyword', $content);
    }

    /**
     * 删除关键词
     *
     * @param $module_id
     */
    final protected function removeKeyword($module_id)
    {
        $where = [
            ['module_id', $module_id],
            ['module', Request::get('m')],
        ];
        $model = Keyword::where($where)->first();
        if ($model) {
            $model->destory();
        }
    }
}



