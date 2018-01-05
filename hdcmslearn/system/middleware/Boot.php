<?php namespace system\middleware;

use system\model\Cloud;
use system\model\Member;
use system\model\Modules;
use system\model\Site;
use system\model\Config as ConfigModel;
use houdunwang\request\Request;
use Db;
use Route;
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

    /**
     * 自动执行的方法
     *
     * @param $next
     *
     * @return mixed
     */
    public function run($next)
    {
        $installed = is_file('data/lock.php');
        //没有安装时跳转到安装界面
        if ( ! $installed && ! preg_match('@setup/app@i', Request::get('s'))) {
            return redirect('setup.app.copyright');
        }

        //已经安装时加载站点数据
        if ($installed) {
            //加载配置项
            $this->config();
            //分析模块域名
            $this->parseDomain();
            //设置路由
            $this->router();
            $this->defineConst();
            User::initUserInfo();
            $this->initSiteData();
            Member::initMemberInfo();
        }
        $next();
    }

    /**
     * 设置常量
     */
    protected function defineConst()
    {
        define('HDCMS_VERSION', Cloud::version());
        define('SITEID', Request::get('siteid', 0));
    }

    /**
     * 加载系统配置项
     * 只加载系统配置不加载站点配置
     * 即网站安装成功后才有系统配置可加载
     * 因为那时已经有数据表存在了
     */
    protected function config()
    {
        $model = ConfigModel::find(1) ?: new ConfigModel();
        $model->initConfig();
    }

    /**
     * 设置模块路由规则
     * 根据站点编号读取该站点规则
     * 并设置到系统路由队列中
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
            if ($siteid = Request::get('siteid')) {
                $routes = Db::table('router')->where('siteid', $siteid)->where('status', 1)->get();
                foreach ($routes as $r) {
                    Route::any($r['router'], 'app\site\controller\Entry@moduleRoute');
                }
            }
        }
    }

    /**
     * 地址中不存在动作标识
     * s m action 时检测域名是否已经绑定到模块
     * 如果存在绑定的模块时设置当请求的的模块
     */
    protected function parseDomain()
    {
        $domain       = trim($_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']), '/\\');
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
    }

    /**
     * 初始化站点数据
     */
    public function initSiteData()
    {
        //初始站点数据
        if (Site::siteInitialize() == false) {
            die(Response::_404());
        }
        //初始模块数据
        if(Modules::moduleInitialize()==false){
            die(Response::_404());
        }
    }
}