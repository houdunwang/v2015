<?php
/**
 * run with command
 * php start.php start
 */

ini_set('display_errors', 'on');

use Workerman\Worker;

if (strpos(strtolower(PHP_OS), 'win') === 0) {
    exit("start.php not support windows, please use start_for_win.bat\n");
}

// 检查扩展
if ( ! extension_loaded('pcntl')) {
    exit("Please install pcntl extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
}

if ( ! extension_loaded('posix')) {
    exit("Please install posix extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
}

// 标记是全局启动
define('GLOBAL_START', 1);
require_once 'vendor/autoload.php';
$config = include "data/database.php";
//print_r($config);
//$dsn      = "mysql:dbname={$config['database']};host={$config['host']}";
//$user     = $config['user'];
//$password = $config['password'];
//$dbh      = new PDO($dsn, $user, $password);

\houdunwang\config\Config::set('database', [
    //调试模式
    'debug'    => true,
    //读库列表
    'read'     => [],
    //写库列表
    'write'    => [],
    //表字段缓存目录
    'cacheDir' => 'storage/field',
    //开启读写分离
    'proxy'    => false,
    //主机
    'host'     => $config['host'],
    //类型
    'driver'   => 'mysql',
    //帐号
    'user'     => $config['user'],
    //密码
    'password' => $config['password'],
    //数据库
    'database' => $config['database'],
    'port'     => 3306,
    //表前缀
    'prefix'   => 'hd_',
]);
$systemConfig = json_decode(\houdunwang\db\Db::table('config')->pluck('site'), true);

// 加载所有Applications/*/start.php，以便启动所有服务
foreach (glob(__DIR__.'/Applications/*/start*.php') as $start_file) {
    require_once $start_file;
}
// 运行所有服务
Worker::runAll();
