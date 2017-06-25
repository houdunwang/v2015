<?php namespace app\admin\controller;

use system\model\Config as ConfigModel;

/**
 * Class Config
 *
 * @package app\admin\controller
 */
class Config extends Common
{
    public function __construct()
    {
        $this->auth();
    }

    /**
     * 网站配置
     */
    public function setting(ConfigModel $config)
    {
        if (IS_POST) {
            $post = Request::post();
            $config->saveConfig($post);

            return $this->setRedirect('refresh')->success('保存成功');
        }
        $model = ConfigModel::find(1);
        $field = $model ? json_decode($model['content'], true) : [];

        return view('', compact('field'));
    }
}
