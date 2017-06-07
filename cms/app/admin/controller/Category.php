<?php namespace app\admin\controller;

use houdunwang\route\Controller;
use system\model\Category as CategoryModel;
use Request;

/**
 * 文章栏目管理
 * Class Category
 *
 * @package app\admin\controller
 */
class Category extends Controller
{
    /**
     * 栏目列表
     *
     * @return mixed
     */
    public function lists()
    {
        $data = CategoryModel::getCategory();

        return view('', compact('data'));
    }

    /**
     * 编辑/添加栏目
     *
     * @param \system\model\Category $categoryModel
     *
     * @return mixed|string
     */
    public function post(CategoryModel $categoryModel)
    {
        $cid   = Request::get('cid');
        $model = $cid ? CategoryModel::find($cid) : $categoryModel;
        if (IS_POST) {
            $model->save(Request::post());

            return $this->setRedirect('lists')->success('保存成功');
        }
        $category = CategoryModel::getCategoryByCid($model);

        return view('', compact('category', 'model'));
    }
}
