<?php namespace app\system\controller\part;

/**
 * 模块安装更新卸载管理
 * Class Setup
 *
 * @package app\system\controller\part
 * @author  向军 <2300071698@qq.com>
 * @site    www.houdunwang.com
 */
class Setup
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
 * 模块配置管理
 * 用于管理当前模块的配置项
 * 每个模块配置是独立管理的互不影响
 * @author {$data['author']}
 * @url http://www.hdcms.com
 */
use module\HdSetup;

class Setup extends HdSetup {
	/**
	 * 模块安装执行的方法
	 */
	public function install() {
	}
	
	/**
	 * 卸载模块时执行的方法
	 */
	public function uninstall() {
	}
	
	/**
	 * 模块更新时执行的方法
	 */
	public function upgrade() {
	}
}
php;
        $file = "addons/{$data['name']}/system/Setup.php";
        if ( ! is_file($file)) {
            file_put_contents($file, $tpl);
        }
    }
}