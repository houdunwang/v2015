<?php namespace app\system\controller\part;

/**
 * 模块业务处理
 * Class Business
 *
 * @package app\system\controller\part
 * @author  向军 <2300071698@qq.com>
 * @site    www.houdunwang.com
 */
class Business
{
    public static function make($data)
    {
        if ($data['business']) {
            foreach ($data['business'] as $b) {
                $action = '';
                foreach ($b['action'] as $a) {
                    $action .= self::action($a);
                }
                self::controller($data, $b, $action);
            }
        }
    }

    protected static function controller($data, $controller, $action)
    {
        $class = ucfirst($controller['controller']);
        $file  = "addons/{$data['name']}/controller/".$class.".php";
        $tpl
               = <<<php
<?php namespace addons\\{$data['name']}\\controller;

/**
 * {$controller['title']}
 * 模板目录为模块根目录下的template文件夹
 * 建议模板以控制器名为前缀,这样在模板文件多的时候容易识别
 * @author {$data['author']}
 * @url http://open.hdcms.com
 */
use module\HdController;

class {$class} extends HdController {

$action
}
php;
        if ( ! is_file($file)) {
            file_put_contents($file, $tpl);
        }
    }

    //动作处理
    protected static function action($d)
    {
        return <<<php
    //{$d['title']} 
    public function {$d['do']}() {
        echo '执行了控制器动作';
    }
php;
    }
}