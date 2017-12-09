<?php namespace app\component\controller;

use houdunwang\request\Request;

/**
 * 选择文件
 * Class File
 *
 * @package app\component\controller
 */
class File extends Common
{
    public function lists()
    {
        return View::make();
    }

    public function get()
    {
        $dir  = Request::post('dir', '.');
        $data = glob($dir.'/*');

        return View::fetch('', compact('data','dir'));
    }
}