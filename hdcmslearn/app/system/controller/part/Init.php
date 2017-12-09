<?php namespace app\system\controller\part;

/**
 * 模块初始执行程序
 * Class Init
 *
 * @package app\system\controller\part
 */
class Init
{
    public static function make($data)
    {
        self::php($data);
    }

    protected static function php($data)
    {
        $tpl
              = <<<php
<?php namespace addons\\{$data['name']}\\system;
/**
 * 模块加载时自动执行类
 * @author {$data['author']}
 * @url http://open.hdcms.com
 */
use module\HdCommon;

class Init extends HdCommon {
	//模块加载时自动执行的方法
	public function run() {
		
	}
}
php;
        $file = "addons/{$data['name']}/system/Init.php";
        if ( ! is_file($file)) {
            file_put_contents($file, $tpl);
        }
    }
}