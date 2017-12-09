<?php namespace app\system\controller\part;

/**
 * 模块消息定阅处理
 * Class Subscribe
 *
 * @package app\system\controller\part
 */
class Subscribe
{
    public static function make($data)
    {
        foreach ($data['subscribes'] as $s) {
            //定阅了任何一个类型的消息时都创建脚本处理程序
            if ( ! empty($s)) {
                return self::php($data);
            }
        }
    }

    protected static function php($data)
    {
        $tpl
              = <<<php
<?php namespace addons\\{$data['name']}\\system;

/**
 * 测试模块消息订阅器
 *
 * @author {$data['author']}
 * @url http://open.hdcms.com
 */
use module\HdSubscribe;
class Subscribe extends HdSubscribe{
	
	/**
	 * 微信消息订阅处理
	 * 微信有新消息后会发到这个方法
	 * 本方法只做微信消息分析
	 * 不要在这里直接回复微信消息,否则会影响整个系统的稳定性
	 * 微信消息类型很多, 系统已经内置了"后盾网微信接口SDK"
	 * 要更全面的使用本功能请查看 SDK文档
	 * @author {$data['author']}
	 * @url http://www.hdcms.com
	 */
	public function handle(){
		//此处理书写订阅处理代码
	}
}
php;
        $file = "addons/{$data['name']}/system/Subscribe.php";
        if ( ! is_file($file)) {
            file_put_contents($file, $tpl);
        }
    }
}