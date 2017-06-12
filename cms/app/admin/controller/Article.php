<?php namespace app\admin\controller;

use houdunwang\request\Request;
use module\WeChat;
use system\model\Category;
use system\model\Article as ArticleModel;

/**
 * Class Article
 *
 * @package app\admin\controller
 */
class Article extends Common
{
    use WeChat;

    public function __construct()
    {
        $this->auth();
    }

    /**
     * 文章列表
     *
     * @return mixed
     */
    public function lists()
    {
        $data = ArticleModel::paginate(v('config.article_row'));

        return view('', compact('data'));
    }

    /**
     * 发表文章
     */
    public function post(ArticleModel $article)
    {
        $id    = Request::get('id');
        $model = $id ? ArticleModel::find($id) : $article;
        if (IS_POST) {
            $post = Request::post();
            $model->save($post);
            $data = ['module' => 'article', 'wechat_keyword' => $post['keyword'], 'module_id' => $model['id']];
            $this->saveKeyword($data);

            return $this->setRedirect('lists')->success('保存成功');
        }
        $category = Category::getCategory();

        return view('', compact('category', 'model'));
    }

    /**
     * 删除文章
     *
     * @return array
     */
    public function remove()
    {
        $model = ArticleModel::find(Request::get('id'));
        $model->destory();

        return $this->setRedirect('lists')->success('删除成功');
    }
}
