<?php namespace app\admin\controller;

use system\model\Category as CategoryModel;
use Request;

/**
 * 文章栏目管理
 * Class Category
 *
 * @package app\admin\controller
 */
class Category extends Common
{
    public function __construct()
    {
        $this->auth();
    }

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

    /**
     * 删除数据
     *
     * @return array
     */
    public function remove(CategoryModel $category)
    {
        $cid = Request::get('cid');
        if ($category->remove($cid)) {
            return $this->setRedirect('lists')->success('删除成功');
        }

        return $this->error($category->getError());
    }
}
