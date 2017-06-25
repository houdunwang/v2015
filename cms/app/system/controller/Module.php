<?php namespace app\system\controller;

use Request;
use Dir;
use system\model\Module as Model;
use houdunwang\validate\Validate;

/**
 * 模块管理
 * Class Module
 *
 * @package app\system\controller
 */
class Module extends Common
{
    /**
     * Module constructor.
     */
    public function __construct()
    {
        $this->auth();
    }

    protected function assignModuleLists()
    {
        $modules = Model::where('is_system', 0)->get();
        View::with('modules', $modules);
    }

    /**
     * 模块列表
     *
     * @return mixed
     */
    public function lists()
    {
        $this->assignModuleLists();
        //已经安装的模块标识
        $installModules = Model::where('is_system', 0)->lists('name');
        $modules        = Dir::tree('addons');
        $data           = [];
        foreach ((array)$modules as $k => $v) {
            $packageFile = 'addons/'.$v['basename'].'/package.json';
            if (is_file($packageFile)) {
                $config              = json_decode(file_get_contents($packageFile), true);
                $config['isinstall'] = in_array($v['basename'], $installModules);
                $data[]              = $config;
            }
        }

        return view('', compact('data'));
    }

    /**
     * 卸载模块
     *
     * @return array
     */
    public function uninstall()
    {
        Model::remove(Request::get('name'));

        return $this->setRedirect('lists')->success('模块卸载成功');
    }

    /**
     * 设计模块
     *
     * @return array|mixed
     */
    public function post()
    {
        if (IS_POST) {
            $post = Request::post();
            Validate::make([
                ['name', 'required', '模块标识不能为空', Validate::MUST_VALIDATE],
                ['name', 'regexp:/^[a-z]{3,10}$/', '模块标识只能为英文字母', Validate::MUST_VALIDATE],
                ['title', 'required', '模块名称不能为空', Validate::MUST_VALIDATE],
                ['preview', 'required', '预览图不能为空', Validate::MUST_VALIDATE],
            ]);
            if (Model::where('name', $post['name'])->first()) {
                return $this->success('模块已经存在');
            }
            if (is_dir('addons/'.$post['name']) || is_dir('module/'.$post['name'])) {
                return $this->success('模块已经存在');
            }
            $post['name'] = strtolower($post['name']);
            //创建模块目录
            $dirs = [
                'controller',
                'module',
                'system',
                'template',
            ];
            foreach ($dirs as $dir) {
                Dir::create("addons/{$post['name']}/".$dir);
            }
            //创建处理微信的文件
            $this->createProcessorFile($post['name']);
            //生成模块配置文件
            $pagkage = json_encode($post, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents('addons/'.$post['name'].'/package.json', $pagkage);
            $this->setRedirect('lists')->success('模块创建成功');
        }
        $this->assignModuleLists();
        return view();
    }

    /**
     * 生成微信处理文件
     *
     * @param $name
     */
    protected function createProcessorFile($name)
    {
        $content
            = <<<str
<?php
namespace addons\\{$name}\system;
use Db;
use module\HdProcessor;
use WeChat;
class Processor extends HdProcessor
{
    public function handler(\$kid)
    {
        //此处理微信消息
    }
}
str;
        file_put_contents("addons/{$name}/system/Processor.php", $content);
    }

    /**
     * 安装模块
     *
     * @return array
     */
    public function install()
    {
        $name              = Request::get('name');
        $data              = json_decode(file_get_contents('addons/'.$name.'/package.json'), true);
        $data['is_system'] = 0;
        $model             = new Model();
        $model->save($data);

        return $this->setRedirect('lists')->success('模块安装成功');
    }
}













