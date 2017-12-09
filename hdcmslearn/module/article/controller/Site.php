<?php namespace module\article\controller;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module\article\controller;

use houdunwang\arr\Arr;
use houdunwang\request\Request;
use module\article\model\Web;
use module\HdController;
use system\model\WeChat;

class Site extends HdController
{
    public function __construct()
    {
        parent::__construct();
        auth();
    }

    /**
     * 添加站点
     *
     * @param \system\model\WeChat $weChatModel
     *
     * @return mixed|string
     */
    public function post(WeChat $weChatModel)
    {
        if (IS_POST) {
            $model                  = Web::where('siteid', siteid())->first() ?: new Web();
            $data                   = json_decode(Request::post('data'), true);
            $model['title']         = $data['title'];
            $model['status']        = $data['status'];
            $model['thumb']         = $data['thumb'];
            $model['template_name'] = $data['template_name'];
            $model['site_info']     = Request::post('data');
            $model->save();
            //添加回复规则
            if ( ! empty($data['keyword'])) {
                $res = WeChat::cover([
                    'keyword'     => $data['keyword'],
                    'title'       => $data['title'],
                    'description' => $data['description'],
                    'thumb'       => $data['thumb'],
                    'url'         => url('entry.index'),
                    'name'        => 'site-cover-'.siteid(),
                ]);
                if ($res !== true) {
                    return message($res, '', 'error');
                }
            }

            return message('保存站点数据成功');
        }
        $model = Web::where('siteid', siteid())->first();
        if ($model) {
            //编辑数据时
            $field       = json_decode($model['site_info'], true);
            $field['id'] = $model['id'];
            /**
             * 微信回复规则编号
             * 用于检测关键词是否存在及添加到rule表中使用
             */
            $field['rid'] = Db::table('rule')->where('name', "article:site:".SITEID)->pluck('rid');
        }
        $field = Arr::merge([
            'status'             => 1,
            'is_default'         => 0,
            'close_message'      => '网站暂时关闭,请稍候访问',
            'title'              => '',
            'template_type'      => 1,//1系统模板 2 自定义目录
            'template_path'      => '',//自定义模板目录时选择的目录
            'template_tid'       => '',
            'template_title'     => '',
            'template_name'      => '',
            'template_thumb'     => '',
            'keyword'            => '',
            'thumb'              => '',
            'keywords'           => '',
            'description'        => '',
            'footer'             => '',
            'index_cache_expire' => 0,//首页缓存时间
            'template_dir_part'  => true,//移动端与桌面端目录分层
        ], $model ? $field : []);
        $field = json_encode($field, JSON_UNESCAPED_UNICODE);

        return view($this->template.'/site/post.php', compact('field'));
    }
}