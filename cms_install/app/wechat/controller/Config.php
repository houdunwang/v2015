<?php namespace app\wechat\controller;

use system\model\WeChatConfig;

/**
 * Class Config
 *
 * @package app\wechat\controller
 */
class Config extends Common
{
    public function __construct()
    {
        $this->auth();
    }

    /**
     * 微信配置
     *
     * @return mixed
     */
    public function setting()
    {
        if (IS_POST) {
            $model       = WeChatConfig::find(1);
            $model       = $model ? $model : new WeChatConfig();
            $model['id'] = 1;
            $model->save(Request::post());

            return $this->setRedirect('refresh')->success('保存成功');
        }
        if ( ! \Config::get('wechat.token')) {
            c('wechat.token', md5(time()));
            c('wechat.encodingaeskey', md5(microtime(true)) . substr(md5(time), 0, 11));
        }

        return view();
    }
}
