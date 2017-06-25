<?php namespace app\admin\controller;

use system\model\Slide as SlideModel;
use Request;

/**
 * 幻灯片管理
 * Class Slide
 *
 * @package app\admin\controller
 */
class Slide extends Common
{
    public function __construct()
    {
        $this->auth();
    }

    /**
     * 幻灯片列表
     *
     * @return mixed
     */
    public function lists()
    {
        $data = SlideModel::get();

        return view('', compact('data'));
    }

    /**
     * 添加/编辑幻灯片
     *
     * @return array|mixed
     */
    public function post()
    {
        $id    = Request::get('id');
        $model = $id ? SlideModel::find($id) : new SlideModel();
        if (IS_POST) {
            $model->save(Request::post());

            return $this->setRedirect('lists')->success('保存成功');
        }

        return view('', compact('model'));
    }

    /**
     * 删除幻灯片
     *
     * @return array
     */
    public function remove()
    {
        $id = Request::get('id');
        if ($model = SlideModel::find($id)) {
            $model->destory();

            return $this->setRedirect('lists')->success('删除成功');
        }

        return $this->error('删除失败');
    }
}
