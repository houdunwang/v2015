<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace module;

use houdunwang\route\Controller;
use Request;
use system\model\Module;

/**
 * 模块继承的公共类
 * Class HdController
 *
 * @package module
 */
abstract class HdController extends Controller
{
    use WeChat;
    /**
     * 模块的模板目录
     *
     * @var string
     */
    protected $template;

    public function __construct()
    {
        $module = Module::where('name', Request::get('m'))->first();

        $this->template = ($module['is_system'] == 1 ? 'module' : 'addons').'/'.$module['name'].'/template';
    }

    public function template($tpl, $vars = [])
    {
        return view($this->template.'/'.$tpl, $vars);
    }
}