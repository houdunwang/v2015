<?php namespace module;

use BaconQrCode\Module;
use system\model\Modules;

/**
 * 模块控制类
 * Class HdRule
 *
 * @package module
 */
abstract class HdRule
{
    //模板目录
    protected $template;

    //配置项
    protected $config;

    //构造函数
    public function __construct()
    {
        auth();
        $Module         = new Modules();
        $this->config   = $Module->getModuleConfig();
        $this->template = MODULE_PATH.'/system/template';
    }
}