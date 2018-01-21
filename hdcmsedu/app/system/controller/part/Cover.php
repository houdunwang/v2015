<?php namespace app\system\controller\part;

/**
 * 模块的功能封面处理
 * Class Cover
 *
 * @package app\system\controller\part
 * @author  向军 <2300071698@qq.com>
 * @site    www.houdunwang.com
 */
class Cover
{
    public static function make($data)
    {
        if ($data['cover']) {
            //组合方法字符串
            $action = '';
            foreach ($data['cover'] as $d) {
                $action .= self::action($d);
            }
            self::php($data, $action);
        }
    }

    protected static function php($data, $action)
    {
        $tpl
              = <<<php
<?php namespace addons\\{$data['name']}\\system;

/**
 * 模块功能封面
 * 功能封面配合图文消息工作
 * 管理员在后台定义好图文消息后
 * 当用户点击图文消息就会执行本类中的相应函数
 * @author {$data['author']}
 * @url http://open.hdcms.com
 */
use module\HdCover;

class Cover extends HdCover {
$action
}
php;
        $file = "addons/{$data['name']}/system/Cover.php";
        if ( ! is_file($file)) {
            file_put_contents($file, $tpl);
        }
    }

    protected static function action($d)
    {
        $tpl
            = <<<php
	//{$d['title']}
	public function {$d['do']}() {
		echo '这是点击封面回复(微信图文消息)后执行';
	}
php;

        return $tpl."\n\n";
    }
}