<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\home\controller;

use Request;
use system\model\Article;
use system\model\Category;
use system\model\Module;

class Entry
{
    protected $template;

    public function __construct()
    {
        $this->template = 'template/'.(IS_MOBILE ? 'mobile' : 'web');
        define('__TEMPLATE__', __ROOT__.'/'.$this->template);
        $this->runModule();
    }

    /**
     * 首页处理
     *
     * @return mixed
     */
    public function index()
    {
        return view($this->template.'/index.html');
    }

    /**
     * 执行控制器
     *
     * @return mixed
     */
    protected function runModule()
    {
        $module = Request::get('m');
        $model  = Module::where('name', $module)->first();
        $action = Request::get('action');
        if ($model and $module and $action) {
            $info    = explode('/', $action);
            $info[1] = ucfirst($info[1]);
            $class   = ($model['is_system'] == 1 ? 'module' : 'addons').'\\'.$module.'\\'.$info[0].'\\'.$info[1];

            die(call_user_func_array([new $class, $info[2]], []));
        }
    }

    /**
     * 文章内容页展示
     *
     * @param $id 文章编号
     *
     * @return mixed
     */
    public function content($id)
    {
        $hdcms = Article::find($id);
        //修改点击数
        $hdcms->where('id',$id)->increment('click', 1);

        return view($this->template.'/content.html', compact('hdcms'));
    }

    /**
     * 栏目页展示
     *
     * @param $cid
     *
     * @return mixed
     */
    public function category($cid)
    {
        $hdcms      = Category::find($cid);
        $hdcms_data = Article::where('category_cid', $cid)->paginate(3);

        return view($this->template.'/list.html', compact('hdcms', 'hdcms_data'));
    }
}