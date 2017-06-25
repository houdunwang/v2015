<?php namespace app\system\controller;

use houdunwang\route\Controller;
use Request;
use Dir;
use system\model\Config;
use system\model\User;
use Schema;
/**
 * 系统安装
 * Class Install
 *
 * @package app\system\controller
 */
class Install extends Controller
{
    /**
     * Install constructor.
     */
    public function __construct()
    {
        $this->isInstalled();
    }

    /**
     * 检测是否已经安装过
     */
    protected function isInstalled()
    {
        if (is_file('lock.php')) {
            die(view('isInstalled'));
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
        $data = [];
        //当前服务器环境
        $data['service_software'] = $_SERVER['SERVER_SOFTWARE'];
        //PHP版本
        $data['php_version'] = PHP_VERSION;
        $data['pdo']         = extension_loaded('Pdo');
        $data['gd']          = extension_loaded('gd');
        $data['curl']        = extension_loaded('curl');
        $data['openssl']     = extension_loaded('openssl');
        $data['root_dir']    = is_writable('.');

        return view('', compact('data'));
    }

    /**
     * 数据库连接配置
     *
     * @return mixed
     */
    public function database()
    {
        if (IS_AJAX) {
            $config = Request::post();
            $dsn    = "mysql:host={$config['host']};dbname={$config['database']}";
            try {
                new \PDO($dsn, $config['user'], $config['password']);
                Dir::create('data');
                file_put_contents('data/database.php', "<?php return ".var_export($config, true).';');

                return $this->success('连接成功');
            } catch (\Exception $e) {
                return $this->error("数据库连接失败<br/>".$e->getMessage());
            }
        }

        return view();
    }

    /**
     * 创建数据表与设置管理员帐号
     *
     * @return string
     */
    public function tables()
    {
        cli('hd migrate:make');
        $model             = new User();
        $model['username'] = 'hdcms';
        $model['password'] = '$2y$10$7k/du6/Zx8a6WUqAoJxce.zTBvfpfM.YALku1JK/PK4Ur8Z/2adeC';
        $model->save();
        //网站配置
        $config                    = new Config();
        $config['content']
                                   = '{"csrf_token":"","webname":"后盾人 人人做后盾","description":"后盾人在线学习平台","icp":"京备1001998281","tel":"13910959565","article_row":"10"}';
        $config['default_message'] = '你说后盾人不清楚哟？houdunwang.com';
        $config['welcome']         = '感谢关注后盾人公众号';
        $config->save();
        //上传表
        $sql=<<<str
CREATE TABLE `attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '会员编号',
  `name` varchar(80) NOT NULL,
  `filename` varchar(300) NOT NULL COMMENT '文件名',
  `path` varchar(300) NOT NULL COMMENT '文件路径',
  `extension` varchar(10) NOT NULL DEFAULT '' COMMENT '文件类型',
  `createtime` int(10) NOT NULL COMMENT '上传时间',
  `size` mediumint(9) NOT NULL COMMENT '文件大小',
  `data` varchar(100) NOT NULL DEFAULT '' COMMENT '辅助信息',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态',
  `content` text NOT NULL COMMENT '扩展数据内容',
  PRIMARY KEY (`id`),
  KEY `data` (`data`),
  KEY `extension` (`extension`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='附件';
str;
        Schema::sql($sql);
        //模块数据
        $sql
            = <<<str
INSERT INTO `module` (`id`, `created_at`, `updated_at`, `name`, `title`, `resume`, `author`, `preview`, `is_system`, `is_wechat`)
VALUES
	(3,'2017-06-12 03:17:55','2017-06-12 03:17:55','student','学生管理系统','学生管理系统','后盾人','attachment/2017/06/08/81511496860815.jpg',0,1),
	(4,'2017-06-12 03:09:00','2017-06-12 03:09:00','base','基本回复','回复微信基本信息','后盾人','attachment/2017/06/08/81511496860815.jpg',1,1),
	(7,'2017-06-13 03:04:01','2017-06-13 03:04:01','article','文章图文回复','文章系统的图文回复','后盾人','attachment/2017/06/08/81511496860815.jpg',1,0);
str;
        Schema::sql($sql);
        return go('finish');
    }

    /**
     * 安装完毕
     */
    public function finish()
    {
        touch('lock.php');

        return view();
    }
}
