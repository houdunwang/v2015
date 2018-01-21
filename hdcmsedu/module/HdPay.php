<?php namespace module;

use houdunwang\xml\Xml;
use system\model\Modules;

/**
 * 支付通知基类
 * Class HdPay
 *
 * @package module
 */
abstract class HdPay
{
    protected $pay;

    //站点编号
    protected $siteid;

    //模板目录
    protected $template;

    //配置项
    protected $config;

    public function __construct()
    {
        Modules::moduleInitialize();
        $this->siteid   = SITEID;
        $this->config   = Modules::getModuleConfig();
        $this->template = (v('module.is_system') ? "module/" : "addons/").v('module.name').'/system/template';
    }
}