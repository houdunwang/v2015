<?php namespace app\system\controller\part;

/**
 * 创建模块服务
 * Class Service
 *
 * @package app\system\controller\part
 */
class Service
{
    public static function make($data)
    {
        return self::php($data);
    }

    protected static function php($data)
    {
        $tpl
              = <<<php
<?php namespace addons\\{$data['name']}\\service;
use module\HdService;
/**
 * 模块服务
 * 服务器就是为了实现模块间通信功能
 * @author {$data['author']}
 * @url http://open.hdcms.com
 */
class Hd extends HdService{
	/**
	 * 调用方式
	 * service('article.hd.make')
	 * service('模块.方法')
	 */
	public function make() {
		echo '服务调用成功';
	}
}
php;
        $file = "addons/{$data['name']}/service/Hd.php";
        if ( ! is_file($file)) {
            file_put_contents($file, $tpl);
        }
    }
}