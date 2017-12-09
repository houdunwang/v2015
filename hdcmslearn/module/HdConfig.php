<?php namespace module;

use system\model\Modules;
use system\model\ModuleSetting;

/**
 * 模块配置管理
 * Class HdConfig
 *
 * @author 向军
 */
abstract class HdConfig
{
    //模板目录
    protected $template;
    //配置项
    protected $config;

    public function __construct()
    {
        auth();
        $this->config   =Modules::getModuleConfig();
        $this->template = MODULE_PATH.'/system/template';
    }

    /**
     * 保存模块配置
     *
     * @param array $field 配置项数据
     */
    public function saveConfig($field)
    {
        $id              = ModuleSetting::where('siteid', SITEID)->where('module', v('module.name'))->pluck('id');
        $model           = $id ? ModuleSetting::find($id) : new ModuleSetting();
        $model['config'] = $field;
        $model->save();
    }
}