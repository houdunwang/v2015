<?php namespace module;

use system\model\Modules;

/**
 * 模块公共处理类
 * Class HdCommon
 *
 * @package module
 */
abstract class HdCommon
{
    //站点编号
    protected $siteid;

    //模板目录
    protected $template;

    //配置项
    protected $config;

    public function __construct()
    {
        $this->siteid = SITEID;
        $this->config = model('Modules')->getModuleConfig();
    }
}