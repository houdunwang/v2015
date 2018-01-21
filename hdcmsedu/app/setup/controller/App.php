<?php namespace app\setup\controller;

use houdunwang\route\Controller;
use houdunwang\session\Session;
use PDO;
use houdunwang\config\Config;
use houdunwang\dir\Dir;
use houdunwang\request\Request;
use houdunwang\db\Db;

/**
 * 系统安装
 * Class App
 *
 * @package app\setup\controller
 */
class App extends Controller
{
    protected $config;

    public function __construct()
    {
        Dir::create('data');
        if (is_file('data/lock.php')) {
            die($this->setRedirect(__ROOT__)->error('请删除data/lock.php文件后执行'));
        }
        //安装环境检测
        $this->environmentalTest();
    }

    /**
     * 安装环境检测
     *
     * @return mixed
     */
    protected function environmentalTest()
    {
        if ( ! is_dir($_SERVER['DOCUMENT_ROOT'] . '/resource/hdjs')) {
            die(view('environmentalTest'));
        }
    }

    /**
     * 版权信息
     *
     * @return mixed
     */
    public function copyright()
    {
        return view();
    }

    /**
     * 环境检测
     *
     * @return mixed
     */
    public function environment()
    {
        //系统信息
        $data['PHP_OS']              = PHP_OS;
        $data['SERVER_SOFTWARE']     = $_SERVER['SERVER_SOFTWARE'];
        $data['PHP_VERSION']         = PHP_VERSION;
        $data['upload_max_filesize'] = get_cfg_var("upload_max_filesize")
            ? get_cfg_var("upload_max_filesize")
            : "不允许上传附件";
        $data['max_execution_time']  = get_cfg_var("max_execution_time") . "秒 ";
        $data['memory_limit']        = get_cfg_var("memory_limit") ? get_cfg_var("memory_limit")
            : "0";
        //运行环境
        $data['h_PHP_VERSION'] = ! version_compare(phpversion(), '5.6.0', '<')
            ? '<i class="fa fa-check-circle fa-1x alert-success"></i>'
            : '<i class="fa fa-times-circle alert-danger"></i>';
        $data['h_Pdo']         = extension_loaded('Pdo')
            ? '<i class="fa fa-check-circle fa-1x alert-success"></i>'
            : '<i class="fa fa-times-circle alert-danger"></i>';
        $data['h_Gd']          = extension_loaded('Gd')
            ? '<i class="fa fa-check-circle fa-1x alert-success"></i>'
            : '<i class="fa fa-times-circle alert-danger"></i>';
        $data['h_curl']        = extension_loaded('curl')
            ? '<i class="fa fa-check-circle fa-1x alert-success"></i>'
            : '<i class="fa fa-times-circle alert-danger"></i>';
        $data['h_openSSL']     = extension_loaded('openSSL')
            ? '<i class="fa fa-check-circle fa-1x alert-success"></i>'
            : '<i class="fa fa-times-circle alert-danger"></i>';
        //目录状态
        $data['d_root'] = is_writable('.')
            ? '<i class="fa fa-check-circle fa-1x alert-success"></i>'
            : '<i class="fa fa-times-circle alert-danger"></i>';

        return view('', compact('data'));
    }

    /**
     * 数据库连接配置
     *
     * @return array|mixed
     */
    public function database()
    {
        if (IS_POST) {
            //测试数据库连接
            $this->config           = Request::post();
            $this->config['prefix'] = 'hd_';
            Config::set('database', array_merge(Config::get('database'), $this->config));
            Session::set('config', Request::post());
            try {
                $host     = $this->config['host'];
                $username = $this->config['user'];
                $password = $this->config['password'];
                $database = $this->config['database'];
                $dsn      = "mysql:host={$host};dbname={$database}";
                new Pdo($dsn, $username, $password,
                    [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]);
                //修改配置文件
                file_put_contents('data/database.php',
                    '<?php return ' . var_export($this->config, true) . ';?>');
            } catch (\Exception $e) {
                die($this->error('数据库不存在或帐号与密码错误'));
            }

            return $this->success('数据库连接成功');
        }

        return view();
    }

    /**
     * 初始表数据
     *
     * @return bool
     */
    public function table()
    {
        if (IS_AJAX) {
            //创建表与初始数据
            cli('hd migrate:make');
            cli('hd seed:make');
            //更新系统版本号
            $version = include 'version.php';
            $data    = [
                'id'       => 1,
                'uid'      => 0,
                'username' => '',
                'webname'  => '',
                'secret'   => '',
                'version'  => $version['version'],
                'build'    => $version['build'],
                'status'   => 0,
            ];

            Db::table('cloud')->replace($data);

            return $this->success('数据表更新成功');
        }

        return view();
    }

    /**
     * 安装完成
     *
     * @return mixed
     */
    public function finish()
    {
        //更改htaccess文件
        if ( ! is_file('.htaccess') && is_file('htaccess.txt')) {
            rename('htaccess.txt', '.htaccess');
        }
        file_put_contents('data/lock.php', 'The installation is complete');
        file_put_contents('data/index.html', "You don't have access");

        return view();
    }
}
