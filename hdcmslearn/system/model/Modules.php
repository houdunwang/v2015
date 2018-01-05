<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace system\model;

use app\system\controller\part\Business;
use app\system\controller\part\Cover;
use app\system\controller\part\Helper;
use app\system\controller\part\Init;
use app\system\controller\part\Processor;
use app\system\controller\part\Service;
use app\system\controller\part\Setup;
use app\system\controller\part\Subscribe;
use app\system\controller\part\Tag;
use houdunwang\cli\Cli;
use houdunwang\container\Container;
use houdunwang\dir\Dir;
use Request;

/**
 * 模块管理
 * Class Modules
 *
 * @package system\model
 */
class Modules extends Common
{
    protected $table = 'modules';
    protected $denyInsertFields = ['mid'];
    protected $validate
        = [
            ['name', 'regexp:/^[a-z]+$/', '模块标识符只能由字母组成', self::MUST_VALIDATE, self::MODEL_INSERT,],
            ['industry', 'required', '模块类型不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['title', 'maxlen:50', '模块名称不能超过50个字符', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['version', 'regexp:/^[\d\.]+$/', '版本号只能为数字', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['resume', 'required', '模块简述不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['detail', 'required', '详细介绍不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['author', 'required', '作者不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['url', 'required', '发布url不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['author', 'required', '作者不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
            ['preview', 'required', '模块封面图片不能为空', self::MUST_VALIDATE, self::MODEL_INSERT],
        ];

    protected $auto
        = [
            ['name', 'strtolower', 'function', self::MUST_AUTO, self::MODEL_INSERT],
            ['is_system', 0, 'string', self::MUST_AUTO, self::MODEL_INSERT],
            ['subscribes', 'json_encode', 'function', self::NOT_EMPTY_AUTO, self::MODEL_INSERT],
            ['processors', 'json_encode', 'function', self::NOT_EMPTY_AUTO, self::MODEL_INSERT],
            ['setting', 'intval', 'function', self::MUST_AUTO, self::MODEL_INSERT],
            ['rule', 'intval', 'function', self::MUST_AUTO, self::MODEL_INSERT],
            ['locality', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT],
            ['build', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['middleware', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
        ];

    protected $industry
        = [
            'business'  => '主要业务',
            'customer'  => '客户关系',
            'marketing' => '营销与活动',
            'tools'     => '常用服务与工具',
            'industry'  => '行业解决方案',
            'other'     => '其他',
        ];

    /**
     * 系统启动时执行的模块初始化
     */
    public static function moduleInitialize()
    {
        $name = Request::get('m');
        if (empty($name)) {
            return true;
        }
        /**
         * 初始化模块数据
         * 加载模块数据到全局变量窗口中
         */
        $module = Db::table('modules')->where('name', $name)->first();
        if (empty($module)) {
            return false;
        }
        $module['path'] = ($module['is_system'] ? "module/" : "addons/").$name;
        v('module', $module);
        /*
        * 加载扩展模块中间件
        */
        $data = Middleware::where('module', v('module.name'))->get();
        if ($data) {
            foreach ($data as $d) {
                \Middleware::add($d['name'], $d['middleware']);
            }
        }
        //模块初始执行程序
        $class = (v('module.is_system') ? "module\\" : "addons\\").v('module.name').'\system\Init';
        if (class_exists($class) && method_exists($class, 'run')) {
            call_user_func_array([new $class, 'run'], []);
        }
        /**
         * 扩展模块单独使用变量访问
         * 而不是使用框架中的s变量
         * 所以当存在a变量时访问到扩展模块处理
         */
        if (Request::get('m') && Request::get('action')) {
            Request::set('get.s', 'site/entry/action');
        }
        //如果存在helpr模块函数库时加载
        $funFile = v('module.path')."/system/helper.php";
        if (is_file($funFile)) {
            require_once $funFile;
        }
        v('module_config', self::getModuleConfig());
        self::defindConst();

        return true;
    }

    /**
     * 定义模块常量
     */
    protected static function defindConst()
    {
        define('MODULE_PATH', v('module.path'));
        define("MODULE_TEMPLATE_PATH", v('module.path')."/template");
        define("MODULE_TEMPLATE_URL", root_url().'/'.v('module.path')."/template");
        define("WIDGET_TEMPLATE_PATH", v('module.path')."/widget/template");
        define("WIDGETE_TEMPLATE_URL", root_url().'/'.v('module.path')."/widget/template");
        //会员中心默认风格
        define('UCENTER_TEMPLATE_PATH', 'ucenter/'.v('site.info.ucenter_template').'/'.(Request::isMobile() ? 'mobile' : 'web'));
        define('UCENTER_TEMPLATE_URL', root_url().'/'.UCENTER_TEMPLATE_PATH);
        define('UCENTER_MASTER_FILE', UCENTER_TEMPLATE_PATH.'/master.php');
    }

    /**
     * 检测模块是否已经安装
     *
     * @param $module
     *
     * @return bool
     */
    public function isInstall($module)
    {
        return $this->where('name', $module)->first() || is_dir("module/{$module}");
    }

    /**
     * 模块是否定义
     *
     * @param $module
     *
     * @return bool
     */
    public function isModule($module)
    {
        return is_dir("addons/{$module}") || is_dir("module/{$module}");
    }

    /**
     * 调用模块方法
     *
     * @param string $module 模块.方法
     * @param array  $params 方法参数
     *
     * @return mixed
     */
    function api($module, $params)
    {
        static $instance = [];
        $info = explode('.', $module);
        if ( ! isset($instance[$module])) {
            $data              = Modules::where('name', $info[0])->first();
            $class             = 'addons\\'.$data['name'].'\api';
            $instance[$module] = new $class;
        }

        return call_user_func_array([$instance[$module], $info[1]], $params);
    }

    /**
     * 验证站点是否拥有模块
     *
     * @param int    $siteId 站点编号
     * @param string $module 模块名称
     *
     * @return bool
     * @throws \Exception
     */
    public function hasModule($siteId = 0, $module = '')
    {
        $siteId = $siteId ?: SITEID;
        $module = $module ?: v('module.name');
        if (empty($siteId) || empty($module)) {
            return false;
        }
        $modules = $this->getSiteAllModules($siteId);
        foreach ($modules as $m) {
            if (strtolower($module) == strtolower($m['name'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * 获取系统所有模块
     *
     * @return mixed
     */
    public function getSystemAllModules()
    {
        $modules = Db::table('modules')->orderBy('mid', 'desc')->get();
        foreach ($modules as $k => $m) {
            //本地模块
            if ($m['is_system'] == 1) {
                $modules[$k]['thumb'] = "module/{$m['name']}/{$m['thumb']}";
            } else {
                $modules[$k]['thumb'] = "addons/{$m['name']}/{$m['preview']}";
            }
        }

        return $modules;
    }

    /**
     * 获取站点模块数据
     * 包括站点套餐内模块和为站点独立添加的模块
     *
     * @param int  $siteId        站点编号
     * @param bool $readFromCache 读取缓存数据
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function getSiteAllModules($siteId = 0, $readFromCache = true)
    {
        $siteId = $siteId ?: siteid();
        if (empty($siteId)) {
            throw new \Exception('获取站点模块数据时, 站点编号不能为空');
        }
        static $cache = [];
        if (isset($cache[$siteId])) {
            return $cache[$siteId];
        }
        //读取缓存
        if ($readFromCache) {
            if ($data = cache("modules", '[get]', 0, [], $siteId)) {
                return $data;
            }
        }
        $package = new Package();
        //获取站点可使用的所有套餐
        $package = $package->getSiteAllPackageData($siteId);
        $modules = [];
        if ( ! empty($package) && $package[0]['id'] == -1) {
            //拥有[所有服务]套餐
            $modules = Modules::get();
            $modules = $modules ? $modules->toArray() : [];
        } else {
            $moduleNames = [];
            foreach ($package as $p) {
                $moduleNames = array_merge($moduleNames, $p['modules']);
            }
            $moduleNames = array_merge($moduleNames, $this->getSiteExtModulesName($siteId));
            if ( ! empty($moduleNames)) {
                $res     = Db::table('modules')->whereIn('name', $moduleNames)->get();
                $modules = $res ?: [];
            }
        }
        //加入系统模块
        $modules   = array_merge($modules, Modules::where('is_system', 1)->get()->toArray());
        $cacheData = [];
        foreach ($modules as $k => $m) {
            $m['subscribes']  = json_decode($m['subscribes'], true) ?: [];
            $m['processors']  = json_decode($m['processors'], true) ?: [];
            $m['permissions'] = array_filter(json_decode($m['permissions'], true) ?: []);
            $binds            = Db::table('modules_bindings')->where('module', $m['name'])->get() ?: [];
            foreach ($binds as $b) {
                //业务动作有多个储存时使用JSON格式的
                if ($b['entry'] == 'business') {
                    $b['do'] = json_decode($b['do'], true);
                }
                $m['budings'][$b['entry']][] = $b;
            }
            $cacheData[$m['name']] = $m;
        }
        cache("modules", $cacheData, 0, ['siteid' => $siteId, 'module' => '']);

        return $cache[$siteId] = $cacheData;
    }

    /**
     * 当前站点使用的非系统模块
     *
     * @return array
     */
    public function currentUseModule()
    {
        foreach (v('site.modules') as $v) {
            if ($v['name'] == v('module.name') && v('module.is_system') == 0) {
                return $v;
            }
        }

        return [];
    }

    /**
     * 获取权限菜单使用的标准模块数组
     * 供 getExtModuleByUserPermission 方法调用
     *
     * @param array  $modules     扩展模块列表
     * @param string $name        模块标识
     * @param string $identifying 权限标识
     * @param string $cat_name    父级菜单标识
     * @param string $title       菜单标题
     * @param array  $permission  原权限数据
     * @param string $url         链接地址
     * @param string $ico         图标
     *
     * @return mixed
     */
    protected function formatModuleAccessData(&$modules, $name, $identifying, $cat_name, $title, $permission, $url, $ico)
    {
        url_del(['mark']);
        $data['name']        = "$name";
        $data['title']       = $title;
        $data['url']         = $url;
        $data['identifying'] = $identifying;
        $data['_status']     = 0;
        $data['ico']         = $ico;
        $data['_hash']       = substr(md5($url), 0, 6);
        if (empty($permission)) {
            $data['_status'] = 1;
        } elseif (isset($permission[$name]) && in_array($identifying, $permission[$name])) {
            $data['_status'] = 1;
        }
        $module                                = v('site.modules.'.$name);
        $modules[$name]['module']              = [
            'title'     => $module['title'],
            'name'      => $module['name'],
            'is_system' => $module['is_system'],
        ];
        $modules[$name]['access'][$cat_name][] = $data;

        return $modules;
    }

    /**
     * 验证标识是否需要验证
     *
     * @param string $module   模块
     * @param string $identify 权限标识
     *
     * @return bool
     */
    public function hasAuthIdentity($module, $identify)
    {
        $access = $this->getExtModuleByUserPermission();
        if ( ! isset($access[$module])) {
            return false;
        }
        foreach ($access[$module]['access'] as $v) {
            foreach ($v as $m) {
                if (strtolower($identify) == strtolower($m['identifying'])) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * 根据用户权限获取用户的模块权限列表
     * 注意:包括站点所有模块
     * 通过属性status判断该用户对某个动作有没有权限
     * 可用于权限菜单与后台模块菜单显示
     *
     * @param int $uid 用户编号
     *
     * @return array
     */
    public function getExtModuleByUserPermission($uid = 0)
    {
        $uid        = $uid ?: v('user.info.uid');
        $user       = new User();
        $permission = $user->getUserAtSiteAccess(siteid(), $uid);
        $modules    = [];
        foreach ((array)v('site.modules') as $name => $m) {
            //对扩展模块进行处理
            if ($m['setting']) {
                $this->formatModuleAccessData($modules, $name, 'system_setting', '系统功能', '参数设置', $permission,
                    "?s=site/config/post&m={$name}&mark=package", 'fa fa-cog');
            }
            if ($m['crontab']) {
                $this->formatModuleAccessData($modules, $name, 'system_crontab', '系统功能', '定时任务', $permission,
                    "?s=site/crontab/lists&m={$name}&mark=package", 'fa fa-globe');
            }
            if ($m['router']) {
                $this->formatModuleAccessData($modules, $name, 'system_router', '系统功能', '路由规则', $permission,
                    "?s=site/router/lists&m={$name}&mark=package", 'fa fa-tachometer');
            }
            if ($m['domain']) {
                $this->formatModuleAccessData($modules, $name, 'system_domain', '系统功能', '域名设置', $permission,
                    "?s=site/domain/post&m={$name}&mark=package", 'fa fa-wordpress');
            }
            if ($m['middleware']) {
                $this->formatModuleAccessData($modules, $name, 'system_middleware', '系统功能', '中间件设置', $permission,
                    "?s=site/middleware/post&m={$name}&mark=package", 'fa fa-twitch');
            }
            if ($m['rule']) {
                $this->formatModuleAccessData($modules, $name, 'system_rule', '微信回复', '回复规则列表', $permission,
                    "?s=site/rule/lists&m={$name}&mark=package", 'fa fa-rss');
            }
            if ($m['budings']['cover']) {
                foreach ($m['budings']['cover'] as $c) {
                    $this->formatModuleAccessData($modules, $name, 'system_cover', '微信回复', $c['title'], $permission,
                        "?s=site/cover/post&m={$name}&mark=package&bid={$c['bid']}", 'fa fa-file-image-o');
                }
            }
            if ($m['budings']['member']) {
                $this->formatModuleAccessData($modules, $name, 'system_member', '导航菜单', '桌面会员中心导航', $permission,
                    "?s=site/navigate/lists&entry=member&m={$name}&mark=package", 'fa fa-renren');
            }
            if ($m['budings']['profile']) {
                $this->formatModuleAccessData($modules, $name, 'system_profile', '导航菜单', '移动会员中心导航', $permission,
                    "?s=site/navigate/lists&entry=profile&m={$name}&mark=package", 'fa fa-github');
            }
            if ($m['budings']['business']) {
                //控制器业务功能
                foreach ($m['budings']['business'] as $c) {
                    foreach ($c['do'] as $d) {
                        $identifying = 'controller/'.$c['controller'].'/'.trim($d['do']);
                        $this->formatModuleAccessData($modules, $name, $identifying, $c['title'], $d['title'],
                            $permission, "?m={$name}&action=controller/{$c['controller']}/{$d['do']}&mark=package",
                            'fa fa-pencil-square-o');
                    }
                }
            }
            //设置模块时添加的扩展权限标识
            //不会在站点后台进行显示
            $extPermissions = Db::table('modules')->where('name', $name)->pluck('permissions');
            $extPermissions = json_decode($extPermissions, true);

            foreach ((array)$extPermissions as $d) {
                $identifying = 'controller/'.trim($d['do']);
                $this->formatModuleAccessData($modules, $name, $identifying, 'extPermissions', $d['title'], $permission,
                    "?m={$name}&action=controller/{$d['do']}&mark=package", 'fa fa-pencil-square-o');
            }
        }

        return $modules;
    }

    /**
     * 用户在站点可以使用的模块数据
     * 只显示可用的没有权限的模块不包含
     *
     * @param int $siteId  站点编号
     * @param int $uid     用户编号
     * @param int $onlyExt 只获取扩展模块
     *
     * @return mixed
     */
    public static function getBySiteUser($siteId = 0, $uid = 0, $onlyExt = 1)
    {
        static $cache = [];
        $name = "cache_{$siteId}{$uid}".intval($onlyExt);
        if ( ! isset($cache[$name])) {
            $siteId = $siteId ?: siteid();
            $uid    = $uid ?: v('user.info.uid');
            //插件模块列表
            $permission = UserPermission::where('siteid', $siteId)->where('uid', $uid)->lists('type,permission');
            $modules    = v('site.modules') ?: [];
            //非管理员时根据其他权限获取模块
            if ( ! User::isManage() && ! empty($permission)) {
                $modules = array_intersect_key($modules, $permission);
            }
            if ($onlyExt) {
                foreach ($modules as $k => $v) {
                    if ($v['is_system'] == 1) {
                        unset($modules[$k]);
                    }
                }
            }
            $cache[$name] = $modules;
        }

        return $cache[$name];
    }

    /**
     * 按行业获取当前站点的模块列表
     * 根据当前使用站点拥有的模块获取
     * 系统管理员获取所有模块
     *
     * @param array $modules 限定模块(只有这些模块获取)
     *
     * @return array
     */
    public function getModulesByIndustry($modules = [])
    {
        $data = [];
        foreach ((array)v('site.modules') as $m) {
            if (in_array($m['name'], $modules) && $m['is_system'] == 0) {
                $data[$this->industry[$m['industry']]][] = [
                    'title'   => $m['title'],
                    'name'    => $m['name'],
                    'preview' => $m['preview'],
                    'thumb'   => $m['thumb'],
                ];
            }
        }

        return $data;
    }

    /**
     * 模块标题列表
     *
     * @return array
     */
    public static function getModuleTitles()
    {
        return [
            'business'  => '主要业务',
            'customer'  => '客户关系',
            'marketing' => '营销与活动',
            'tools'     => '常用服务与工具',
            'industry'  => '行业解决方案',
            'other'     => '其他',
        ];
    }

    /**
     * 获取模块配置
     *
     * @param string $module 模块名称
     *
     * @return array
     */
    public static function getModuleConfig($module = '')
    {
        static $cache = [];
        $module = $module ?: v('module.name');
        if ( ! isset($config[$module])) {
            $config = ModuleSetting::where('siteid', SITEID)->where('module', $module)->pluck('config');

            return $cache[$module] = $config ? json_decode($config, true) : [];
        }

        return $cache[$module];
    }

    /**
     * 获取站点扩展模块数据
     *
     * @param string $siteId 网站编号
     *
     * @return array
     */
    public function getSiteExtModules($siteId)
    {
        $module = SiteModules::where('siteid', $siteId)->lists('module');

        return $module ? Modules::whereIn('name', $module)->get() : [];
    }

    /**
     * 获取站点扩展模块名称列表
     *
     * @param int $siteId 站点编号
     *
     * @return array
     */
    public function getSiteExtModulesName($siteId)
    {
        return SiteModules::where('siteid', $siteId)->lists('module') ?: [];
    }

    /**
     * 获取拥有桌面主页访问的模块列表
     *
     * @return array
     */
    public function getModuleHasWebPage()
    {
        $modules = array_keys($this->getSiteAllModules());

        return Db::table('modules')
                 ->field('modules.mid,modules.title,modules.name,modules.is_system')
                 ->join('modules_bindings', 'modules.name', '=', 'modules_bindings.module')
                 ->whereIn('modules.name', $modules)
                 ->where('modules_bindings.entry', 'web')
                 ->groupBy('modules.name')
                 ->get();
    }

    /**
     * 是否为本地模块
     *
     * @param string $name 模块标识
     *
     * @return bool
     */
    public function isLocalModule($name)
    {
        return is_dir("addons/{$name}") && ! is_file("addons/{$name}/cloud.php");
    }

    /**
     * 是否为系统模块
     *
     * @param $name 模块标识
     *
     * @return bool
     */
    public function isSystemModule($name)
    {
        $mod = Modules::where('name', $name)->first();

        return $mod && $mod['is_system'] == 1;
    }

    /**
     * 是否为远程模块
     *
     * @param $name 模块标识
     *
     * @return bool
     */
    public function isCloudModule($name)
    {
        return is_dir("addons/{$name}") && is_file("addons/{$name}/cloud.php");
    }

    /**
     * 设置模块
     *
     * @param array $data 模块数据
     *
     * @return bool|int
     */
    public function design($data)
    {
        //模块结构数据
        $data = $this->formatPackageJson($data);
        //字段基本检测
        Validate::make([
            ['title', 'required', '模块名称不能为空'],
            ['industry', 'required', '请选择行业类型'],
            ['name', 'regexp:/^[a-z]+$/', '模块标识必须以英文小写字母构成'],
            ['version', 'regexp:/^[\d\.]+$/i', '请设置版本号, 版本号只能为数字或小数点'],
            ['resume', 'required', '模块简述不能为空'],
            ['detail', 'required', '请输入详细介绍'],
            ['author', 'required', '作者不能为空'],
            ['url', 'required', '请输入发布url'],
            ['compatible_version', 'required', '请选择兼容版本'],
            ['preview', 'required', '模块封面图不能为空'],
        ], $data);
        //模块标识转小写
        $data['name'] = strtolower($data['name']);
        $dir          = "addons/".$data['name'];
        //检查插件是否存在
        $isSystem = Db::table('modules')->where('is_system', 1)->where('name', $data['name'])->get();
        $isCloud  = is_file("module/{$data['name']}/cloud.php");
        if ($isSystem || $isCloud) {
            return '模块是系统模块或云模块不允许创建,请更改模块标识';
        }
        //系统关键字不允许定义为模块标识
        if (in_array($data['name'], ['user', 'system', 'houdunwang', 'houdunyun', 'hdphp', 'hd', 'hdcms', 'xj',])) {
            return '模块已经存在,请更改模块标识';
        }
        //创建目录创建安全文件
        foreach (['controller', 'template', 'api', 'service/template', 'model', 'system', 'system/template', 'widget/template'] as $d) {
            if ( ! Dir::create("{$dir}/{$d}")) {
                return '模块目录创建失败,请修改addons目录的权限';
            }
            file_put_contents("{$dir}/{$d}/index.html", 'Not allowed to access');
        }
        //模块预览图
        $info    = pathinfo($data['preview']);
        $preview = $dir.'/preview.'.$info['extension'];
        copy($data['preview'], $preview);
        $data['preview'] = 'preview.'.$info['extension'];
        //初始创建模块需要的脚本文件
        Tag::make($data);
        Subscribe::make($data);
        Processor::make($data);
        Cover::make($data);
        Business::make($data);
        Setup::make($data);
        Service::make($data);
        Init::make($data);
        Helper::make($data);
        \app\system\controller\part\Navigate::make($data);
        \app\system\controller\part\Config::make($data);
        \app\system\controller\part\Rule::make($data);
        \app\system\controller\part\Pay::make($data);

        return file_put_contents($dir.'/package.json', json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) ? true : false;
    }

    /**
     * 格式化模块配置文件用于安装模块
     * 移除无效的数据
     *r
     *
     * @param $data
     *
     * @return mixed
     */
    protected function formatPackageJson($data)
    {
        if (empty($data['web']['entry']['title']) || empty($data['web']['entry']['do'])) {
            $data['web']['entry'] = [];
        }
        //桌面会员中心
        foreach ($data['web']['member'] as $k => $d) {
            if (empty($d['title']) || empty($d['do'])) {
                unset($data['web']['member'][$k]);
            }
        }
        //移动端导航设置
        foreach ($data['mobile']['home'] as $k => $d) {
            if (empty($d['title']) || empty($d['do'])) {
                unset($data['mobile']['home'][$k]);
            }
        }
        //移动端会员中心
        foreach ($data['mobile']['member'] as $k => $d) {
            if (empty($d['title']) || empty($d['do'])) {
                unset($data['mobile']['member'][$k]);
            }
        }
        //封面回复
        foreach ($data['cover'] as $k => $d) {
            if (empty($d['title']) || empty($d['do'])) {
                unset($data['cover'][$k]);
            }
        }
        //业务动作
        foreach ($data['business'] as $k => $d) {
            //检测动作完整性
            foreach ($data['business'][$k]['action'] as $n => $m) {
                if (empty($m['title']) || empty($m['do'])) {
                    unset($data['business'][$k]['action'][$n]);
                }
            }
            //控制器数据不完整时删除
            if (empty($d['title']) || empty($d['controller']) || empty($data['business'][$k]['action'])) {
                unset($data['business'][$k]);
            }
        }

        return $data;
    }

    /**
     * 执行数据迁移
     *
     * @param string $name 模块标识
     *
     * @return bool
     */
    public function migrateMake($name)
    {
        Cli::setPath([
            'migration' => "addons/{$name}/database/migrations",
            'seed'      => "addons/{$name}/database/seeds",
        ]);
        if (Cli::call("hd migrate:make") === false) {
            $this->setError(Cli::getError());

            return false;
        }

        return true;
    }

    /**
     * 执行数据填充
     *
     * @param string $name 模块标识
     *
     * @return bool
     */
    public function seedsMake($name)
    {
        Cli::setPath([
            'migration' => "addons/{$name}/database/migrations",
            'seed'      => "addons/{$name}/database/seeds",
        ]);
        if (Cli::call("hd seed:make") === false) {
            $this->setError(Cli::getError());

            return false;
        }

        return true;
    }

    /**
     * 重置数据迁移
     *
     * @param string $name 模块标识
     *
     * @return bool
     */
    public function migrateReset($name)
    {
        foreach (glob("addons/{$name}/database/migrations/*") as $file) {
            $info = pathinfo($file);
            require $file;
            $namespace = "addons\\{$name}\\database\migrations";
            $class     = $namespace.'\\'.substr($info['basename'], 13, -4);
            (new $class)->down();

            Db::table('migrations')->where('migration', $info['basename'])->delete();
        }

        return true;
    }

    /**
     * 迁移回滚
     *
     * @param string $name 模块标识
     *
     * @return mixed
     */
    public function migrateRollback($name)
    {
        $data = glob("addons/{$name}/database/migrations/*");
        rsort($data);
        foreach ($data as $file) {
            $info = pathinfo($file);
            require $file;
            $namespace = "addons\\{$name}\\database\migrations";
            $class     = $namespace.'\\'.substr($info['basename'], 13, -4);
            (new $class)->down();

            return Db::table('migrations')->where('migration', $info['basename'])->delete();
        }
    }


    /**
     * 安装模块
     *
     * @param $name
     *
     * @return string
     */
    public function install($name)
    {
        if ($this->isInstall($name)) {
            return '模块已经安装或已经存在系统模块, 你可以卸载后重新安装';
        }
        //执行数据迁移
        if ($this->migrateMake($name) === false) {
            return false;
        }
        //执行安装脚本
        $this->exceInstallFile($name);
        $res = $this->initModuleData($name);
        if ($res !== true) {
            return $res;
        }
        //更新远程模块时间
        $this->updateCloudModuleInfo($name);

        return true;
    }

    /**
     * 设置云信息包括云模块编译时间
     *
     * @param $name
     *
     * @return bool
     */
    public function updateCloudModuleInfo($name)
    {
        //远程模块更新模块数据
        if ($this->isCloudModule($name)) {
            //设置云信息包括云模块编译时间
            $config = include "addons/{$name}/cloud.php";
            $data   = ['locality' => 0, 'build' => $config['zip']['build']];

            return self::where('name', $config['name'])->update($data);
        }
    }

    /**
     * 执行模块的安装程序
     *
     * @param $name 模块标识
     *
     * @return bool
     */
    public function exceInstallFile($name)
    {
        $class = 'addons\\'.$name.'\system\Setup';

        call_user_func_array([new $class, 'install'], []);

        return true;
    }

    /**
     * 安装或更新模块时添加模块业务数据
     *
     * @param $module 模块标识
     *
     * @return bool
     */
    public function initModuleData($module)
    {
        $dir    = "addons/{$module}";
        $config = json_decode(file_get_contents("{$dir}/package.json"), true);
        //执行模块更新表语句
        $class = 'addons\\'.$module.'\system\Setup';
        call_user_func_array([new $class, 'upgrade'], []);
        //权限标识处理
        $permissions = [];
        foreach ((array)preg_split('/\n/', $config['permissions']) as $v) {
            $d = explode(':', $v);
            if (count($d) == 2) {
                $permissions[] = ['title' => trim($d[0]), 'do' => trim($d[1])];
            }
        }
        //添加到模块系统中
        $model = new Modules();
        $model->where('name', $module)->delete();
        $model['name']        = trim($config['name']);
        $model['version']     = trim($config['version']);
        $model['industry']    = trim($config['industry']);
        $model['title']       = trim($config['title']);
        $model['url']         = trim($config['url']);
        $model['resume']      = trim($config['resume']);
        $model['detail']      = trim($config['detail']);
        $model['author']      = trim($config['author']);
        $model['rule']        = trim($config['rule']);
        $model['thumb']       = trim($config['thumb']);
        $model['preview']     = trim($config['preview']);
        $model['tag']         = trim($config['tag']);
        $model['is_system']   = 0;
        $model['subscribes']  = $config['subscribes'];
        $model['processors']  = $config['processors'];
        $model['setting']     = $config['setting'];
        $model['middleware']  = $config['middleware'];
        $model['crontab']     = $config['crontab'];
        $model['router']      = $config['router'];
        $model['domain']      = $config['domain'];
        $model['permissions'] = json_encode($permissions, JSON_UNESCAPED_UNICODE);
        $model['locality']    = is_file($dir.'/cloud.php') ? 0 : 1;
        $model->save();
        self::initModuleBinding($module);

        //更新所有站点缓存
        return Container::callMethod(Site::class, 'updateAllCache');
    }

    /**
     * 重建模块动作
     *
     * @param string $module 模块标识
     *
     * @return bool
     */
    public function initModuleBinding($module)
    {
        $dir    = "addons/{$module}";
        $config = json_decode(file_get_contents("{$dir}/package.json"), true);
        //添加模块动作表数据
        ModulesBindings::where('module', $module)->delete();
        if ( ! empty($config['web']['entry'])) {
            $d           = $config['web']['entry'];
            $d['module'] = $module;
            $d['entry']  = 'web';
            $d['do']     = trim($d['do']);
            (new ModulesBindings())->save($d);
        }
        if ( ! empty($config['web']['member'])) {
            foreach ($config['web']['member'] as $d) {
                $d['entry']  = 'member';
                $d['module'] = $module;
                $d['do']     = trim($d['do']);
                (new ModulesBindings())->save($d);
            }
        }
        if ( ! empty($config['mobile']['home'])) {
            foreach ($config['mobile']['home'] as $d) {
                $d['entry']  = 'home';
                $d['module'] = $module;
                $d['do']     = trim($d['do']);
                (new ModulesBindings())->save($d);
            }
        }
        if ( ! empty($config['mobile']['member'])) {
            foreach ($config['mobile']['member'] as $d) {
                $d['entry']  = 'profile';
                $d['module'] = $module;
                $d['do']     = trim($d['do']);
                (new ModulesBindings())->save($d);
            }
        }
        if ( ! empty($config['cover'])) {
            foreach ($config['cover'] as $d) {
                $d['entry']  = 'cover';
                $d['module'] = $module;
                $d['do']     = trim($d['do']);
                (new ModulesBindings())->save($d);
            }
        }
        if ( ! empty($config['business'])) {
            foreach ($config['business'] as $d) {
                if ( ! empty($d['action'])) {
                    $d['entry']  = 'business';
                    $d['module'] = $module;
                    $d['do']     = json_encode($d['action'], JSON_UNESCAPED_UNICODE);
                    (new ModulesBindings())->save($d);
                }
            }
        }

        return true;
    }

    /**
     * 从系统中删除模块
     *
     * @param      $name 模块标识
     *
     * @return bool
     */
    public function remove($name)
    {
        $module = Db::table('modules')->where('name', $name)->first();
        if (empty($module) || $module['is_system'] == 1) {
            $this->setError('模块不存或者模块为系统模块无法删除');

            return false;
        }
        //执行模块本身的卸载程序
        $this->migrateReset($name);
        //云模板时删除目录
        if (is_file("addons/{$name}/cloud.php")) {
            if ( ! Dir::del("addons/{$name}")) {
                $this->setError('云模块目录删除失败');

                return false;
            }
        }
        $this->uninstallModuleSoft($name);
        //删除模块系统数据
        $this->removeModuleSystemData($name);
        //删除模块
        self::where('name', $name)->delete();

        //更新所有站点缓存
        return Site::updateAllCache();
    }

    /**
     * 执行模块卸载程序
     *
     * @param string $name 模块标识
     *
     * @return bool
     */
    protected function uninstallModuleSoft($name)
    {
        $class = 'addons\\'.$name.'\system\Setup';
        if (class_exists($class) && method_exists($class, 'uninstall')) {
            return call_user_func_array([new $class, 'uninstall'], []);
        }

        return true;
    }

    /**
     * 删除模块系统数据
     *
     * @param string $name 模块标识
     *
     * @return bool
     */
    protected function removeModuleSystemData($name)
    {
        //更新套餐数据
        $package = new Package();
        $package->removeModule($name);
        //删除模块关联表
        $relationTables = [
            'module_domain',
            'module_setting',
            'modules_bindings',
            'site_modules',
            'navigate',
            'ticket_module',
        ];
        foreach ($relationTables as $t) {
            Db::table($t)->where('module', $name)->delete();
        }
        //删除模块使用的微信规则与关键词数据
        (new SiteWeChat())->removeRuleByModule($name);

        return true;
    }
}