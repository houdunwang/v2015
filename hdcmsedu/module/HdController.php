<?php namespace module;

use houdunwang\response\Response;
use houdunwang\route\Controller;
use module\article\model\Web;
use system\model\Modules;
use Code;
use system\model\Site;
use houdunwang\session\Session;
use View;
use Request;

/**
 * 模块业务基类
 * Class HdController
 *
 * @package module
 */
abstract class HdController extends Controller
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
        $this->siteid = siteid();

        if (empty($this->siteid)) {
            $this->_404('siteid Is Not Found');
        }
        $module         = new Modules();
        $this->config   = $module->getModuleConfig();
        $this->template = MODULE_TEMPLATE_PATH;
        //文章模块目录设置
        $this->articleTemplate();
        //来源页面
        if (isset($_GET['from'])) {
            Session::set('from', Request::get('from', '', ['urldecode']));
        }
        $this->fromUrl = Session::get('from') ?: url('member.index', [], 'ucenter');
    }

    /**
     * 文章模块模板目录
     *
     * @return string
     */
    protected function articleTemplate()
    {
        if ( ! defined('ARTICLE_PATH')) {
            $template = '';
            if ($web = Web::where('siteid', SITEID)->first()) {
                $web      = $web->info();
                $template = $web->getTemplate();
                if ($web['site_info']['template_dir_part'] == true) {
                    $template .= (IS_MOBILE ? 'mobile' : 'web');
                }
            }
            define('ARTICLE_PATH', $template);
            define('ARTICLE_URL', root_url().'/'.$template);
        }

        return ARTICLE_PATH ?: '';
    }

    /**
     * 更新站点缓存
     *
     * @param int $siteid 站点编号
     *
     * @return bool
     * @throws \Exception
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