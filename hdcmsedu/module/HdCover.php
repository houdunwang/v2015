<?php namespace module;

use system\model\Modules;

/**
 * 封面回复基础类
 * Class HdCover
 *
 * @package module
 * @author  向军
 */
abstract class HdCover
{
    //模板目录
    protected $template;

    //配置项
    protected $config;

    public function __construct()
    {
        auth();
        $this->config   = Modules::getModuleConfig();
        $this->template = MODULE_PATH.'/system/template';
    }
}