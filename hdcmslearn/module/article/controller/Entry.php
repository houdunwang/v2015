<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module\article\controller;

use module\article\model\Web;
use module\article\model\WebCategory;
use module\article\model\WebContent;
use module\HdController;

/**
 * 前台入口处理
 * Class Entry
 *
 * @package module\article\controller
 */
class Entry extends HdController
{
    protected $web;

    public function __construct()
    {
        parent::__construct();
        $this->web      = Web::where('siteid', SITEID)->first()->info();
        $this->template = $this->template();
        View::with('module.site', json_decode(Db::table('web')->pluck('site_info'), true));
        define('ARTICLE_PATH', $this->template);
        define('ARTICLE_URL', root_url().'/'.$this->template);
    }

    /**
     * 设置模板目录
     *
     * @return string
     */
    protected function template()
    {
        $template = $this->web->getTemplate();
        if ($this->web['site_info']['template_dir_part'] == true) {
            return $template.(IS_MOBILE ? 'mobile' : 'web');
        }

        return $template;
    }

    /**
     * 站点首页访问
     *
     * @return mixed
     */
    public function index()
    {
        $info = $this->web->info();

        return $this->view($this->template.'/index')->cache($info['site_info']['index_cache_expire']);
    }

    /**
     * 栏目访问入口
     *
     * @return mixed
     */
    public function category()
    {
        $category = WebCategory::find(Request::get('cid'));
        //设置模型编号
        Request::set('get.mid', $category['mid']);
        $hdcms = $category->toArray();
        $tpl   = $this->template.'/'.($category['ishomepage'] ? $category['index_tpl'] : $category['category_tpl']);

        return $this->view($tpl, compact('hdcms'));
    }

    /**
     * 文章内容页访问入口
     *
     * @return mixed|string
     */
    public function content()
    {
        $model = WebContent::find(Request::get('aid'));
        if (empty($model)) {
            return message('你访问的文章不存在', '', 'error');
        }
        $hdcms    = $model->toArray();
        $category = WebCategory::find($hdcms['cid'])->toArray();
        //设置栏目链接
        $category['url']   = WebCategory::url($category);
        $hdcms['category'] = $category;
        $hdcms['user']     = Db::table('user')->where('uid', $hdcms['uid'])->first();
        View::with(['hdcms' => $hdcms]);
        $tpl = $this->template.'/'.($hdcms['template'] ?: $category['content_tpl']);

        return $this->view($tpl);
    }
}