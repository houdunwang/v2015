<?php namespace module;

use system\model\Modules;

/**
 * 服务业务基类
 * Class HdService
 *
 * @package module
 */
abstract class HdService
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
        $this->template = MODULE_PATH.'/service/template';
    }
}