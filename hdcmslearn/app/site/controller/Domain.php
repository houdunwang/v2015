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
use system\model\ModuleDomain;
use system\model\Site;

/**
 * 域名设置
 * Class Domain
 *
 * @package app\site\controller
 */
class Domain extends Admin
{
    //设置域名
    public function post()
    {
        auth('system_domain');
        if (IS_POST) {
            //删除旧域名
            ModuleDomain::where('module', v('module.name'))->where('siteid', siteid())->delete();
            $domains = array_filter(Request::post('domain', []));
            foreach ($domains as $domain) {
                $has = ModuleDomain::where('domain', $domain)->first();
                if ($has) {
                    $site = Site::find($has['siteid']);
                    return message("{$domain}已经被站点 {$site['name']}<br/>使用在 {$has['module']} 模块", '', 'error');
                }
                $model           = new ModuleDomain();
                $model['module'] = v('module.name');
                $model['domain'] = $domain;
                $model->save();
            }

            return message('域名信息保存成功', '', 'success');
        }
        $data = Db::table('module_domain')->where('module', v('module.name'))->where('siteid', siteid())->get();

        return view('', compact('data'));
    }
}