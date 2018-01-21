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

use system\model\ReplyCover;
use system\model\RuleKeyword;
use system\model\SiteWeChat;

/**
 * 模块封面回复管理
 * Class Cover
 *
 * @package app\site\controller
 */
class Cover extends Admin
{
    /**
     * 扩展模块封面回复设置
     *
     * @param \system\model\ReplyCover  $ReplyCover
     * @param \system\model\RuleKeyword $RuleKeyword
     * @param \system\model\Rule        $Rule
     *
     * @return mixed|string
     */
    public function post(ReplyCover $ReplyCover, RuleKeyword $RuleKeyword, \system\model\Rule $Rule)
    {
        auth('system_cover');
        //获取模块封面回复动作信息
        $module = Db::table('modules_bindings')->where('bid', Request::get('bid'))->first();
        //回复的url会记录到reply_cover数据表中用于判断当前回复是否已经设置了
        if (IS_POST) {
            $data             = json_decode(Request::get('keyword'), true);
            $cover            = $ReplyCover->getModuleCover(v('module.name'), $module['do']);
            $data['name']     = v('module.name').':'.$module['title'];
            $data['rid']      = $cover['rid'];
            $data['module']   = 'cover';
            $data['rank']     = $data['istop'] == 1 ? 255 : min(255, intval($data['rank']));
            $data['keywords'] = $data['keyword'];
            $rid              = SiteWeChat::rule($data);
            //添加封面回复
            $model                = $cover ? ReplyCover::find($cover['id']) : new ReplyCover();
            $model['url']         = $module['do'];
            $model['rid']         = $rid;
            $model['title']       = Request::post('title');
            $model['description'] = Request::post('description');
            $model['thumb']       = Request::post('thumb');
            $model['url']         = $ReplyCover->getModuleCoverUrl(v('module.name'), $model['do']);
            $model['module']      = v('module.name');
            $model->save();

            return message('功能封面更新成功', '', 'success');
        }
        //模块封面回复数据
        $field = $ReplyCover->getModuleCover(v('module.name'), $module['do']);
        //获取关键词回复
        if ($field) {
            View::with('rule', $Rule->getRuleByRid($field['rid']));
        }

        return view()->with('field', $field);
    }
}