<?php namespace app\system\controller\part;

/**
 * 模块的导航菜单
 * Class Processor
 *
 * @package app\system\controller\part
 * @author  向军 <2300071698@qq.com>
 * @site    www.houdunwang.com
 */
class Navigate
{
    public static function make($data)
    {
        $action = '';
        if ( ! empty($data['web']['entry'])) {
            $action .= self::entry($data['web']['entry'])."\n\n";
        }

        if ( ! empty($data['web']['member'])) {
            foreach ($data['web']['member'] as $d) {
                $action .= self::webMember($d)."\n\n";
            }
        }
        if ( ! empty($data['mobile']['home'])) {
            foreach ($data['mobile']['home'] as $d) {
                $action .= self::mobileHome($d)."\n\n";
            }
        }
        if ( ! empty($data['mobile']['member'])) {
            foreach ($data['mobile']['member'] as $d) {
                $action .= self::mobileMember($d)."\n\n";
            }
        }
        if ( ! empty($action)) {
            self::php($data, $action);
        }
    }

    protected static function php($data, $action)
    {
        $tpl
              = <<<php
<?php namespace addons\\{$data['name']}\\system;

/**
 * 模块导航菜单处理
 *
 * @author {$data['author']}
 * @url http://open.hdcms.com
 */
use module\HdNavigate;

class Navigate extends HdNavigate {

$action
}
php;
        $file = "addons/{$data['name']}/system/Navigate.php";
        if ( ! is_file($file)) {
            file_put_contents($file, $tpl);
        }
    }

    //桌面入口菜单
    protected static function entry($d)
    {
        return <<<php
	/**
	 * {$d['title']} [桌面入口导航菜单]
	 * 在网站管理中将模块设置为默认执行模块然后配置好域名
	 * 当使用配置的域名访问时会执行这个方法
	 */
    public function {$d['do']}() {
    }
php;
    }

    //
    protected static function webMember($d)
    {
        return <<<php
	/**
	 * {$d['title']} [桌面会员中心菜单]
	 * 使用PC端访问时在会员中心显示的菜单
	 */
    public function {$d['do']}() {
    }
php;
    }

    //移动端首页菜单
    protected static function mobileHome($d)
    {
        return <<<php
	/**
	 * {$d['title']} [移动端首页菜单]
	 * 使用移动端设备如手机访问时
	 * 在站点首页显示的菜单
	 */
    public function {$d['do']}() {
    }
php;
    }

    //移动端会员中心菜单
    protected static function mobileMember($d)
    {
        return <<<php
	/**
	 * {$d['title']} [移动端会员中心菜单]
	 * 使用移动端设备如手机访问时
	 * 在会员中心显示的菜单
	 */
    public function {$d['do']}() {
    }
php;
    }
}