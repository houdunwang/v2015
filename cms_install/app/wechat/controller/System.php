<?php namespace app\wechat\controller;

use houdunwang\route\Controller;
use Request;
use system\model\Config;

/**
 * 系统回复处理
 * Class System
 *
 * @package app\wechat\controller
 */
class System extends Controller
{
    //默认回复，关注公众号时的回复
    public function post()
    {
        $model = Config::find(1) ?: new Config();
        if (IS_POST) {
            $post = Request::post();
            $model->save($post);
            $this->setRedirect('refresh')->success('保存成功');
        }

        return view('',compact('model'));
    }
}
