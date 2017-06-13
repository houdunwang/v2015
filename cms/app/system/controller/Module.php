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
    public function __construct()
    {
        $this->auth();
    }

    /**
     * 模块列表
     *
     * @return mixed
     */
    public function lists()
    {
        $data = Model::where('is_system', 0)->get();

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

    public function post()
    {
        if (IS_POST) {
            $post = Request::post();
            Validate::make([
                ['name', 'required', '模块标识不能为空', Validate::MUST_VALIDATE],
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
            $model = new Model();
            $model->save($post);
            $this->setRedirect('lists')->success('模块创建成功');
        }

        return view();
    }

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
}













