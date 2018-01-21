<?php namespace system\model;

use houdunwang\curl\Curl;
use houdunwang\dir\Dir;
use Db;
use houdunwang\zip\Zip;

/**
 * 后盾云
 * Class Cloud
 *
 * @package system\model
 */
class Cloud extends Common
{
    protected $table = 'cloud';

    protected $allowFill = ['*'];

    protected $validate = [];

    protected static $host = 'http://www.hdcms.com';
    protected $auto
        = [
            ['uid', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['username', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['AppID', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['AppSecret', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['versionCode', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['releaseCode', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT],
            ['createtime', 'time', 'function', self::MUST_AUTO, self::MODEL_BOTH],
        ];

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * 获取连接主机
     *
     * @return string
     */
    public static function getHost()
    {
        $accounts = Db::table('cloud')->first();
        if (in_array($_SERVER['SERVER_NAME'], ['test.hdcms.com'])) {
            self::$host = 'http://hdcms.hdcms.com';
        }

        return self::$host
               . "?secret={$accounts['secret']}&uid={$accounts['uid']}&secret={$accounts['secret']}&m=store&action=controller";
    }

    /**
     * 验证云帐号状态
     *
     * @return bool
     */
    public static function checkAccount()
    {
        $accounts = Db::table('cloud')->first();

        return boolval($accounts['status']);
    }

    /**
     * 绑定云帐号
     *
     * @param $data 帐号、密码、密钥数据
     *
     * @return mixed
     */
    public static function connect($data)
    {
        $res   = Curl::post(self::getHost() . '/cloud/connect', $data);
        $res   = json_decode($res, true);
        $model = static::find(1);
        if ($res['valid'] == 1) {
            //连接成功
            $model['uid']      = $res['uid'];
            $model['username'] = $data['username'];
            $model['secret']   = $data['secret'];
            $model['webbam']   = $data['secret'];
            $model['status']   = 1;
            $model->save();
        }

        return $res;
    }

    /**
     * 获取系统公告
     *
     * @param int $row 条数
     *
     * @return mixed
     */
    public static function getSystemNotice($row = 5)
    {
        $data = static::find(1)->toArray();
        $res  = Curl::post(self::getHost() . '/cloud/getSystemNotice&row=' . $row, $data);

        return json_decode($res, true);
    }

    /**
     * 获取HDCMS的更新列表
     * 与当前版本无关
     *
     * @param int $row 条数
     *
     * @return mixed
     */
    public static function getUpgradeList($row = 5)
    {
        $res = Curl::get(self::getHost() . '/cloud/getUpgradeList&row=' . $row);

        return json_decode($res, true);
    }

    /**
     * 获取当前版本后的更新列表
     *
     * @return mixed
     */
    public static function getLastUpgradeList()
    {
        $data = self::find(1)->toArray();
        $res  = Curl::post(self::getHost() . '/cloud/getLastUpgradeList&', $data);

        return json_decode($res, true);
    }

    /**
     * 获取当前版本号
     *
     * @return string
     */
    public static function version()
    {
        return self::where('id', 1)->pluck('version');
    }

    /**
     * 获取HDCMS新版本
     *
     * @return array
     */
    public static function getUpgradeVersion()
    {
        $data = static::find(1)->toArray();
        $res  = Curl::post(self::getHost() . '/cloud/getUpgradeVersion', $data);

        return json_decode($res, true);
    }

    /**
     * 更新云上的系统安装数量
     *
     * @return mixed
     */
    public static function updateHDownloadNum()
    {
        $build = Db::table('cloud')->where('id', 1)->pluck('build');
        $res   = Curl::get(self::getHost() . '/cloud/updateHDownloadNum&build=' . $build);

        return json_decode($res, true);
    }

    /**
     * 升级系统时备份当前版本的HDCMS
     *
     * @return bool
     */
    public static function backup()
    {
        $current = Db::table('cloud')->find(1);
        //将旧版本文件进行备份
        if (is_file('upgrade/hdcms/upgrade_files.php')) {
            foreach (include 'upgrade/hdcms/upgrade_files.php' as $f) {
                Dir::copyFile($f['file'], "upgrade/{$current['version']}/{$f['file']}");
            }
        }

        return true;
    }

    /**
     * 下载系统更新包
     *
     * @return array
     */
    public static function downloadUpgradeVersion()
    {
        $res = self::getLastUpgradeList();
        if ($res['valid'] == 1) {
            Dir::create('upgrade');
            foreach ($res['hdcms'] as $d) {
                file_put_contents('upgrade/hdcms.zip', Curl::get($d['file']));
                Zip::open('upgrade/hdcms.zip')->extract('upgrade');
                self::backup();
                Dir::move('upgrade/hdcms', '.');
                break;
            }
            Dir::delFile('upgrade/hdcms.zip');
            //复制的更新列表文件
            Dir::delFile('upgrade_files.php');
        }

        return $res;
    }

    /**
     * 获取商城中的模块或模板列表
     *
     * @param string $type    类型 module/template
     * @param string $page    页数
     *
     * @param string $appType buy:已经购买
     *
     * @return mixed
     */
    public static function apps($type, $page, $appType = '')
    {
        $content = Curl::get(self::getHost() . "/cloud/apps&type={$type}&page={$page}&appType="
                             . $appType);
        $apps    = json_decode($content, true);
        if ($apps['valid'] == 1) {
            //已经安装的所模块
            $modules = Modules::lists('name');
            foreach ($apps['apps'] as $k => $v) {
                //是否安装
                $apps['apps'][$k]['is_install'] = in_array($v['name'], $modules) ? true : false;
            }
        }

        return $apps;
    }

    /**
     * 获取模块更新列表
     *
     * @return array|bool|mixed
     */
    public static function getModuleUpgradeLists()
    {
        $post = Modules::where('locality', 0)->lists('name,build');
        if (empty($post)) {
            return ['valid' => 1, 'message' => '没有可更新的模块', 'apps' => ''];
        }
        $content = Curl::post(self::getHost() . "/cloud/getModuleUpgradeLists", $post);
        $apps    = json_decode($content, true);
        if ($apps['valid'] == 1) {
            return $apps;
        } else {
            return $apps;
        }
    }

    /**
     * 更新指定模块
     *
     * @param $name 模块标识
     *
     * @return array|mixed
     */
    public function upgradeModuleByName($name)
    {
        $module = Db::table('modules')->where('name', $name)->first();
        $res    = Curl::post(self::getHost() . "/cloud/getModuleUpgrade", $module);
        $app    = json_decode($res, true);
        if ($app['valid'] == 1) {
            //下载压缩文件
            $content = Curl::get($app['zip']['file']);
            Dir::create('upgrade/module');
            $file = "addons/{$name}.zip";
            file_put_contents($file, $content);
            Zip::open($file)->extract('addons');
            file_put_contents("addons/{$name}/cloud.php",
                '<?php return ' . var_export($app, true) . ';?>');
            //删除下载压缩包
            Dir::delFile($file);
            //执行数据迁移
            if ((new Modules())->migrateMake($name) === false) {
                return ['message' => '执行模块数据迁移失败', 'valid' => 0,];
            }
            //初始化模块数据
            (new Modules())->initModuleData($name);
            //更新数据表模块编译版本
            $data = ['version' => $app['zip']['version'], 'build' => $app['zip']['build']];
            Modules::where('name', $name)->update($data);

            return ['message' => '模块更新完毕', 'config' => $app, 'valid' => 1,];
        } else {
            return $app;
        }
    }

    /**
     * 下载应用
     *
     * @param $type     应用类型模块或模板
     * @param $name     应用标识
     *
     * @return array|mixed
     */
    public static function downloadApp($type, $name)
    {
        if (empty($type) || empty($name)) {
            return ['valid' => 0, 'message' => '应用标识或类型错误'];
        }
        //安装前检测
        switch ($type) {
            case 'module':
                if (Modules::where('name', $name)->get()) {
                    return ['valid' => 0, 'message' => '应用不允许重复安装'];
                }
                if (is_dir("addons/{$name}") && ! is_file("addons/{$name}/cloud.php")) {
                    return ['valid' => 0, 'message' => '已经存在本地开发的同名模块'];
                }
                break;
            case 'template':
                if (is_dir("theme/{$name}") && ! is_file("addons/{$name}/cloud.php")) {
                    return ['valid' => 0, 'message' => '同名模板已经存在'];
                }
                break;
        }
        //获取模块信息
        $app = Curl::get(self::getHost() . "/cloud/getLastAppByName&type={$type}&name={$name}");
        $app = json_decode($app, true);
        if ($app['valid'] == 0) {
            return $app;
        }
        Dir::create('addons');
        //文件保存
        switch ($type) {
            case 'module':
                //下载文件
                $content = Curl::get($app['zip']['file']);
                if (Curl::getCode() != 200) {
                    return ['valid' => 0, 'message' => '网络连接失败，请稍候再试'];
                }
                $file = "addons/{$app['name']}.zip";
                file_put_contents($file, $content);
                Zip::open($file)->extract('addons');
                //删除下载压缩包
                Dir::delFile($file);
                file_put_contents("addons/{$app['name']}/cloud.php",
                    '<?php return ' . var_export($app, true) . ';?>');
                break;
            case 'template':
                //下载文件
                $content = Curl::get($app['file']);
                if (Curl::getCode() != 200) {
                    return ['valid' => 0, 'message' => '网络连接失败，请稍候再试'];
                }
                $file = "theme/{$app['name']}.zip";
                file_put_contents($file, $content);
                Zip::open($file)->extract('theme');
                //删除下载压缩包
                Dir::delFile($file);
                file_put_contents("theme/{$app['name']}/cloud.php",
                    '<?php return ' . var_export($app, true) . ';?>');
        }

        return [
            'message' => '应用下载完成准备开始安装',
            'config'  => $app,
            //模板和目录安装变量不同需要设置 module与name两个
            'url'     => u($type . '.install', ['module' => $app['name'], 'name' => $app['name']]),
            'valid'   => 1,
        ];
    }
}