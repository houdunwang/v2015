<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDPHP framework]
 * |      Site: www.hdphp.com  www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * |     Weibo: http://weibo.com/houdunwangxj
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace app\cli;

/**
 * Trait Make
 *
 * @package app\cli
 */
trait Make
{
    /**
     * 创建模型
     *
     * @return bool|int
     */
    public function model()
    {
        $info      = explode('.', $_SERVER['argv'][0]);
        $namespace = 'addons\\'.$info[0]."\\model";
        $MODEL     = ucfirst($info[1]);
        $TABLE     = strtolower($info[0].'_'.$info[1]);
        $file      = 'addons/'.$info[0]."/model/{$MODEL}.php";
        //创建模型文件
        if (is_file($file)) {
            return $this->error("Model file already exists");
        }
        $data    = file_get_contents(__DIR__.'/view/model.tpl');
        $content = str_replace(['{{NAMESPACE}}', '{{MODEL}}', '{{TABLE}}'], [$namespace, $MODEL, $TABLE], $data);

        return file_put_contents($file, $content);
    }

    /**
     * 创建控制器
     *
     * @return bool|int
     */
    public function controller()
    {
        $info      = explode('.', $_SERVER['argv'][0]);
        $CLASS     = ucfirst($info[1]);
        $namespace = 'addons\\'.$info[0]."\\controller";
        $file      = 'addons/'.$info[0]."/controller/{$CLASS}.php";
        //创建模型文件
        if (is_file($file)) {
            return $this->error("Model file already exists");
        }
        $data    = file_get_contents(__DIR__.'/view/controller.tpl');
        $content = str_replace(['{{NAMESPACE}}', '{{CLASS}}'], [$namespace, $CLASS], $data);

        return file_put_contents($file, $content);
    }
}