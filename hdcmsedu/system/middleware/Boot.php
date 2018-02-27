<?php namespace system\middleware;

use houdunwang\response\Response;
use system\model\Cloud;
use system\model\Config;
use system\model\Member;
use system\model\Modules;
use system\model\Site;
use houdunwang\request\Request;
use houdunwang\db\Db;
use houdunwang\route\Route;
use system\model\User;

/**
 * 应用启动中间件
 * Class Boot
 *
 * @package system\middleware
 */
class Boot
{
    protected $installed;

    public function __construct()
    {
        $this->installed = is_file('data/lock.php');
    }

    /**
     * 自动执行的方法
     *
     * @param $next
     *
     * @return mixed
     */
    public function run($next)
    {
        //没有安装时跳转到安装界面
        if ( ! $this->installed and ! preg_match('@setup/app@i', Request::get('s'))) {
            return redirect('setup.app.copyright');
        }
        $this->installed and $this->app();
        //执行安装程序时
        $this->defineConst();
        //调试时允许跨域访问
        if (\Config::get('app.debug')) {
            header('Access-Control-Allow-Origin:*');
            header('Access-Control-Allow-Headers:*');
        }

        $next();
    }

    /**
     * 运行应用
     */
    protected function app()
    {
        //加载系统配置项
        Config::findOrCreate(1)->initConfig();
        //分析模块域名与路由
        $this->parseDomain()->router()->defineConst();
        $this->initSiteData();
        User::initUserInfo();
        Member::initMemberInfo();
    }

    /**
     * 设置常量
     *
     * @return $this
     */
    protected function defineConst()
    {
        defined('HDCMS_VERSION') or define('HDCMS_VERSION',
            $this->installed ? Cloud::version() : 999);
        defined('SITEID') or define('SITEID', Request::get('siteid', 0));

        return $this;
    }

    /**
     * 地址中不存在动作标识
     * s m action 时检测域名是否已经绑定到模块
     * 如果存在绑定的模块时设置当请求的的模块
     *
     * @return $this
     */
    protected function parseDomain()
    {
        $domain       = trim($_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']), '/\\');
        $moduleDomain = Db::table('module_domain')->where('domain', $domain)->first();
        if ($moduleDomain) {
            //没有站点编号时设置域名所在站点编号
            if ( ! Request::get('siteid')) {
                Request::set('get.siteid', $moduleDomain['siteid']);
            }
            //没有模块参数时设置模块参数
            if ( ! Request::get('m') && ! Request::get('s') && ! Request::get('action')) {
                Request::set('get.m', $moduleDomain['module']);
            }
        }

        return $this;
    }

    /**
     * 设置模块路由规则
     * 根据站点编号读取该站点规则
     * 并设置到系统路由队列中
     *
     * @return $this
     */
    protected function router()
    {
        $url = preg_replace('@/index.php/@', '', $_SERVER['REQUEST_URI']);
        $url = trim($url, '/');
        if (preg_match('@^([a-z]+)(\d+)@', $url, $match)) {
            //设置站点与模块变量
            if (count($match) == 3) {
                Request::set('get.siteid', $match[2]);
                Request::set('get.m', $match[1]);
            }
            $siteid = Request::get('siteid');
            if ($siteid && ! Request::get('s')) {
                $routes = Db::table('router')->where('siteid', $siteid)->where('status', 1)->get();
                foreach ($routes as $r) {
                    Route::any($r['router'], 'app\site\controller\Entry@moduleRoute');
                }
            }
        }

        return $this;
    }

    /**
     * 初始化站点数据
     *
     * @return $this
     */
    public function initSiteData()
    {
        //初始站点数据
        if (Site::siteInitialize() == false) {
            die(Response::_404());
        }
        //初始模块数据
        if (Modules::moduleInitialize() == false) {
            die(Response::_404());
        }

        return $this;
    }
}