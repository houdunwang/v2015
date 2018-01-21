<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\site\controller;

use houdunwang\request\Request;
use system\model\Middleware as MiddlewareModel;

/**
 * 模块中间件管理
 * Class Middleware
 *
 * @package app\site\controller
 */
class Middleware extends Admin
{
    public function post()
    {
        auth('system_middleware');
        if (IS_POST) {
            $model = new MiddlewareModel();
            //删除原中间件
            $model->where('module', v('module.name'))->delete();
            $data = json_decode(Request::post('data'), true);
            foreach ($data as $d) {
                if ( ! empty($d['title']) && ! empty($d['name']) && ! empty($d['middleware'])) {
                    //检测处理类是否存在
                    if (class_exists($d['middleware'])) {
                        p($data);
                        $db               = new MiddlewareModel();
                        $db['title']      = $d['title'];
                        $db['name']       = $d['name'];
                        $db['middleware'] = $d['middleware'];
                        $db['module']     = v('module.name');
                        $db->save();
                    }
                }
            }

            return message('中间件数据保存成功', '', 'success');
        }

        $data = MiddlewareModel::where('module', v('module.name'))->get();
        View::with('data', $data ? json_encode($data->toArray(), JSON_UNESCAPED_UNICODE) : '[]');

        return view();
    }
}