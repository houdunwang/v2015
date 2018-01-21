<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * |     Weibo: http://weibo.com/houdunwangxj
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\pay\controller;

use system\model\Pay;

trait Base
{
    /**
     * 获取调用支付的模块对象
     *
     * @param $name
     *
     * @return string
     */
    protected function getModule($name)
    {
        $module = Db::table('modules')->where('name', $name)->first();

        $class = ($module['is_system'] == 1 ? 'module\\' : 'addons\\').$name.'\system\Pay';

        return new $class;
    }

    /**
     * 更新支付表状态
     *
     * @param string $tid 定单号
     * @param string $pay_id 微信/支付宝等定单号
     *
     * @return mixed
     */
    protected function updateOrderStatus($tid,$pay_id)
    {
        $model = Pay::where('tid', $tid)->first();
        if ($model && $model['status'] == 0) {
            $model['status'] = 1;
            $model['pay_id'] = $pay_id;
            $model->save();
        }
        return $model;
    }
}