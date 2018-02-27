<?php namespace module\article\controller;

/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
use module\HdController;
use system\model\Template as TemplateModel;
use houdunwang\request\Request;

/**
 * 官网模板管理
 * Class Template
 *
 * @package module\article\controller
 */
class Template extends HdController
{
    public function __construct()
    {
        parent::__construct();
        auth();
    }

    /**
     * 选择模板
     *
     * @param \system\model\Template $TemplateModel
     *
     * @return mixed
     * @throws \Exception
     */
    public function lists(TemplateModel $TemplateModel)
    {
        $data = $TemplateModel->getSiteAllTemplate(SITEID, Request::get('type'));

        return view($this->template . '/template/template_lists')->with(['data' => $data]);
    }

    /**
     * 当前风格中的模板文件
     * 用于为栏目或文章设置个性模板
     *
     * @param \system\model\Template $TemplateModel
     *
     * @return mixed
     */
    public function files(TemplateModel $TemplateModel)
    {
        $template = $TemplateModel->getTemplateData();
        $dir      = "theme/{$template['name']}";
        //桌面端模板
        $web = glob($dir . '/web/*.php');

        return view($this->template . '/template/template_files', compact('web'));
    }
}