<?php namespace module\special\controller;

use module\HdController;
use module\hdSite;
use system\model\SiteSetting;

/**
 * 微信关注时或默认回复内容设置
 * Class Site
 *
 * @package module\special\controller
 */
class Site extends HdController
{
    //系统消息回复设置
    public function post()
    {
        if (IS_POST) {
            Validate::make([
                ['welcome', 'required', '欢迎信息关键字 不能为空'],
                ['default', 'required', '默认信息关键字 不能为空'],
            ]);
            $setting                  = SiteSetting::where('siteid', SITEID)->first();
            $model                    = $setting ? SiteSetting::find($setting['id']) : new SiteSetting();
            $model['welcome']         = Request::post('welcome');
            $model['default_message'] = Request::post('default');
            $model->save();
            $this->updateSiteCache();

            return message('系统回复消息设置成功', '', 'success');
        }

        return view($this->template.'/post.html');
    }
}