<?php namespace module\ucenter\controller;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

use houdunwang\request\Request;
use module\HdController;
use system\model\Navigate;
use system\model\Page;
use system\model\SiteWeChat;
use View;

/**
 * 后台移动端界面管理
 * Class Style
 *
 * @package module\ucenter\controller
 */
class Style extends HdController
{
    public function __construct()
    {
        parent::__construct();
        auth('feature_ucenter_post');
    }

    /**
     * 移动端界面设置
     *
     * @param \system\model\SiteWeChat $weChatModel
     * @param \system\model\Page       $Page
     *
     * @return mixed|string
     * @throws \Exception
     */
    public function post(SiteWeChat $weChatModel, Page $Page)
    {
        if (IS_POST) {
            //模块数据
            $modules = json_decode(Request::post('modules'), true);
            //查找旧的文章数据如果有时为编辑动作
            $res                  = Page::where('siteid', $this->siteid)->where('type', 'profile')->first();
            $model                = $res['id'] ? Page::find($res['id']) : new Page();
            $model['title']       = $modules['head']['title'];
            $model['description'] = $modules['head']['description'];
            $model['params']      = $modules;
            $model['html']        = Request::post('html');
            $model['type']        = 'profile';
            $model['status']      = 1;
            $model->save();
            /**
             * 添加菜单
             * 首先删除原菜单然后添加新菜单
             */
            $menus = json_decode(Request::post('menus'), true);
            Navigate::where('siteid', $this->siteid)->where('entry', 'profile')->delete();
            foreach ((array)$menus as $m) {
                $NavigateModel = new Navigate();
                if ( ! empty($m['name'])) {
                    $data['name']     = $m['name'];
                    $data['css']      = $m['css'];
                    $data['url']      = $m['url'];
                    $data['icontype'] = 1;
                    $data['entry']    = 'profile';
                    $NavigateModel->save($data);
                }
            }
            //************************************回复关键词处理************************************
            //会员中心顶部资料,回复关键词,描述,缩略图
            $ucenter = $modules[0]['params'];
            //添加图文回复
            $weChatModel->cover([
                'name'        => '##移动端会员中心##',
                'keyword'     => $ucenter['keyword'],
                'title'       => $ucenter['title'],
                'description' => $ucenter['description'],
                'thumb'       => $ucenter['thumb'],
                'url'         => url('member.index'),
            ]);

            return message('会员中心视图保存成功');
        }
        //模块参数
        $modules = $Page->getParamsByType('profile');
        View::with(['modules' => $modules, 'menus' => $this->getProfileMenu()]);

        return view($this->template.'/style/post.php');
    }

    /**
     * 获取菜单
     *
     * @return string
     */
    public function getProfileMenu()
    {
        $navigate = new Navigate();

        return json_encode($navigate->getMenuByEntry('profile'));
    }
}