<?php namespace module;

use houdunwang\config\Config;
use houdunwang\response\Response;
use houdunwang\route\Controller;
use system\model\Member;
use system\model\Modules;
use Code;
use system\model\Site;

/**
 * 模块业务基类
 * Class HdController
 *
 * @package module
 */
abstract class HdWidget extends Controller
{
    //站点编号
    protected $siteid;

    //模板目录
    protected $template;

    //配置项
    protected $config;

    //回调地址
    protected $fromUrl;

    public function __construct()
    {
        $this->siteid   = siteid();
        $module         = new Modules();
        $this->config   = $module->getModuleConfig();
        $this->template = WIDGET_TEMPLATE_PATH;
        //来源页面
        if (isset($_GET['from'])) {
            Session::set('from', Request::get('from', '', ['urldecode']));
        }
        $this->fromUrl = Session::get('from') ?: url('member.index', [], 'ucenter');
    }

    /**
     * 更新站点缓存
     *
     * @param int $siteid 站点编号
     *
     * @return bool
     */
    public function updateSiteCache($siteid = 0)
    {
        return Site::updateCache($siteid);
    }

    /**
     * 显示视图
     *
     * @param       $file 模板文件
     * @param array $args 模板参数
     *
     * @return string
     */
    protected function view($file, array $args = [])
    {
        if ( ! preg_match('@\.php$@i', $file)) {
            $file = $file.'.php';
        }

        if ( ! is_file($file)) {
            die(Response::_404());
        }

        return View::make($file, $args);
    }
}