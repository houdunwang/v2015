<?php namespace module;

use houdunwang\route\Controller;
use system\model\Modules;

/**
 * 模块菜单基础类
 * Class HdNavigate
 *
 * @package module
 */
abstract class HdNavigate extends Controller
{
    //站点编号
    protected $siteid;

    //模板目录
    protected $template;

    //配置项
    protected $config;

    public function __construct()
    {
        $this->siteid   = SITEID;
        $this->config   = Modules::getModuleConfig();
        $this->template = MODULE_PATH.'/system/template';
    }
}