<?php namespace app\system\controller\part;

/**
 * 创建模块函数库
 * Class Helper
 *
 * @package app\system\controller\part
 */
class Helper
{
    public static function make($data)
    {
        self::php($data);
    }

    protected static function php($data)
    {
        $tpl
              = <<<php
<?php 
/**
 * 模块函数库
 * 系统自动加载此文件
 * 这个文件中的函数应用到系统业务中
 * @url http://open.hdcms.com
 */
function hd_test(){
	echo '函数库工作了';
}
php;
        $file = "addons/{$data['name']}/system/helper.php";
        if ( ! is_file($file)) {
            file_put_contents($file, $tpl);
        }
    }
}