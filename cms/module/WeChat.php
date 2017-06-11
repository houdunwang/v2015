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
     * @param array $data
     */
    final protected function saveKeyword(array $data)
    {
        $data['module']    = Request::get('m');
        $data['module_id'] = empty($data['module_id']) ? 0 : $data['module_id'];
        $model             = new Keyword();
        $model->save($data);
    }
}