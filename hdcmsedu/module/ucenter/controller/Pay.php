<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module\ucenter\controller;

use houdunwang\request\Request;
use system\model\Pay as Model;
use View;
/**
 * 支付记录
 * Class Credit
 *
 * @package module\ucenter\controller
 */
class Pay extends Auth
{
    /**
     * 积分/余额列表
     *
     * @return mixed
     */
    public function lists()
    {
        if ($timerange = Request::get('timerange')) {
            //有筛选时间的
            $timerange = explode('至', $timerange);
            $data      = Model::where('uid', v('member.info.uid'))->where('siteid', SITEID)
                              ->where('updated_at', '>=', $timerange[0])
                              ->where('updated_at', '<=', $timerange[1])->orderBy('pid','DESC')->paginate(10);
        } else {
            $data = Model::where('uid', v('member.info.uid'))->where('siteid', SITEID)->orderBy('pid','DESC')->paginate(8);
        }

        return View::make($this->template.'/pay_lists', compact('data'));
    }
}