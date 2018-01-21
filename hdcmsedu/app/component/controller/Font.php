<?php namespace app\component\controller;

/**
 * 字体
 * Class Font
 *
 * @package app\component\controller
 */
class Font extends Common
{
    //字体列表
    public function lists()
    {
        $this->auth();

        return View::make();
    }
}