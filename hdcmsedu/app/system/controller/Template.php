<?php namespace app\system\controller;

use system\model\Package;
use system\model\Template as TemplateModel;
use Dir;
use Request;
use houdunwang\validate\Validate;
use houdunwang\db\Db;

/**
 * 文章模板管理
 * Class Template
 *
 * @package app\system\controller
 */
class Template extends Admin
{
    public function __construct()
    {
        $this->superUserAuth();
    }

    /**
     * 设置新模板
     *
     * @return mixed|string
     */
    public function design()
    {
        if (IS_POST) {
            $data = json_decode(Request::post('data'), JSON_UNESCAPED_UNICODE);
            //字段基本检测
            Validate::make(
                [
                    ['title', 'required', '模板名称不能为空'],
                    ['industry', 'required', '请选择行业类型'],
                    ['name', 'regexp:/^[a-z]+$/i', '模板标识必须为英文字母'],
                    ['resume', 'required', '模板简述不能为空'],
                    ['author', 'required', '作者不能为空'],
                    ['url', 'required', '请输入发布url'],
                    ['thumb', 'required', '官网预览图不能为空'],
                    ['position', 'regexp:/^\d+$/', '微站导航菜单数量必须为数字'],
                ],
                $data
            );
            //模板标识转小写
            $data['name'] = strtolower($data['name']);
            //检查模板是否存在
            if (is_dir('theme/'.$data['name'])
                || Db::table('template')->where('name', $data['name'])->first()) {
                return message('模板已经存在,请更改模板标识', 'back', 'error');
            }

            foreach (['web', 'mobile'] as $dir) {
                if ( ! Dir::create("theme/{$data['name']}/{$dir}")) {
                    return message('模板目录创建失败,请修改目录权限', 'back', 'error');
                }
            }

            //创建模板初始文件
            foreach (['index.php', 'article_index.php', 'article_list.php', 'article.php'] as $file)
            {
                file_put_contents("theme/{$data['name']}/web/{$file}", '');
                file_put_contents("theme/{$data['name']}/mobile/{$file}", '');
            }

            //预览图
            $info = pathinfo($data['thumb']);
            copy($data['thumb'], 'theme/'.$data['name'].'/thumb.'.$info['extension']);

            $data['thumb'] = 'thumb.'.$info['extension'];
            $package       = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents("theme/{$data['name']}/package.json", $package);

            return message('模板创建成功', 'prepared', 'success');
        }

        return view();
    }

    /**
     * 已经安装模板
     *
     * @param \system\model\Template $template
     *
     * @return mixed
     */
    public function installed(TemplateModel $template)
    {
        $data = $template->get()->toArray();
        foreach ($data as $k => $m) {
            //缩略图
            $data[$k]['thumb'] = pic("theme/{$m['name']}/{$m['thumb']}");
        }

        return view()->with('template', $data);
    }

    /**
     * 生成压缩包
     */
    public function createZip()
    {
        $name = Request::get('name');
        $zip  = $name.".zip";
        //设置编译时间
        $config          = json_decode(file_get_contents("theme/{$name}/package.json"), true);
        $config['build'] = time();
        file_put_contents(
            "theme/{$name}/package.json",
            json_encode($config, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
        //压缩文件
        Zip::create($zip, ["theme/{$name}"]);
        File::download($zip, $zip);
        @unlink($zip);
    }

    /**
     * 安装模板列表
     *
     * @return mixed
     */
    public function prepared()
    {
        $templates = TemplateModel::lists('name');
        //本地模板
        $locality = [];
        foreach (Dir::tree('theme') as $d) {
            if ($d['type'] == 'dir' && is_file($d['path'].'/package.json')) {
                if ($config = json_decode(file_get_contents("{$d['path']}/package.json"), true)) {
                    //去除已经安装的模板
                    if ( ! in_array($config['name'], $templates)) {
                        //预览图片
                        $config['thumb']           = "theme/{$config['name']}/{$config['thumb']}";
                        $locality[$config['name']] = $config;
                    }
                }
            }
        }

        return view()->with(compact('locality'));
    }

    /**
     * 安装模板
     *
     * @param \system\model\Template $template
     * @param \system\model\Package  $package
     *
     * @return mixed|string
     */
    public function install(TemplateModel $template, Package $package)
    {
        //模板安装检测
        if ($m = $template->where('name', Request::get('name'))->first()) {
            return message($m['title'].'模板已经安装', 'back', 'error');
        }
        $configFile = 'theme/'.Request::get('name').'/package.json';
        if ( ! is_file($configFile)) {
            return message('配置文件不存在,无法安装', '', 'error');
        }
        $config = json_decode(file_get_contents($configFile), true);
        if ( ! $config) {
            return message('模板配置文件解析失败', 'back', 'error');
        }
        if (IS_POST) {
            //整合添加到模板表中的数据
            $config['is_system']  = 0;
            $config['is_default'] = 0;
            $config['locality']   = 1;
            $template->save($config);
            //在服务套餐中添加模板
            $packageLists = Request::post('package');
            if ($packageLists) {
                $package = $package->whereIn('name', $packageLists)->get();
                foreach ($package as $p) {
                    $templateLists   = json_decode($p['template'], true) ?: [];
                    $templateLists[] = $config['name'];
                    $p['template']   = $templateLists;
                    $p->save();
                }
            }

            return message("模板安装成功", u('installed'));
        }

        return view()->with(compact('config', 'package'));
    }

    /**
     * 卸载模板
     *
     * @param \system\model\Template $template
     *
     * @return mixed|string
     */
    public function uninstall(TemplateModel $template)
    {
        $name = Request::get('name');
        if (IS_POST) {
            if ( ! $template->remove($name)) {
                return message($template->getError(), '', 'error');
            }

            return message('模板卸载成功', u('installed'));
        }

        $field = $template->where('name', $name)->first();

        return view('', compact('field'));
    }
}