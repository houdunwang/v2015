<?php namespace app\component\controller;

use system\model\Template;
use Db;

/**
 * 模块与模板
 * Class Module
 *
 * @package app\component\controller
 */
class Module
{
    public function __construct()
    {
        auth();
    }

    /**
     * 模块列表
     *
     * @return mixed
     */
    public function moduleBrowser()
    {
        $modules    = v('site.modules');
        $useModules = explode(',', q('get.mid', '', []));

        return view('', compact('modules', 'useModules'));
    }

    /**
     * 模块列表
     *
     * @return mixed
     */
    public function moduleList()
    {
        $modules = Db::table('modules')->get();

        return view('', compact('modules'));
    }

    /**
     * 模块与模板列表
     * 添加站点时选择扩展模块时使用
     *
     * @return mixed
     */
    public function ajaxModulesTemplate()
    {
        $modules   = Db::table('modules')->where('is_system', 0)->get();
        $templates = Db::table('template')->where('is_system', 0)->get();

        return view()->with(compact('modules', 'templates'));
    }

    /**
     * 选择站点模板模板
     *
     * @param \system\model\Template $templateModel
     *
     * @return mixed
     * @throws \Exception
     */
    public function siteTemplateBrowser(Template $templateModel)
    {
        $data = $templateModel->getSiteAllTemplate();

        return view('', compact('data'));
    }
}