<?php
/**
 * 文章管理控制器
 */
class ArticleController extends Controller{
	public function filters(){
		return array(
				array(
					'system.web.widgets.COutputCache + index',
					'duration'	=> 30,
					'varyByParam'=> array('aid')
					),
			);
	}
	/**
	 * 默认显示
	 */
	public function actionIndex($aid){
		$articleInfo = Article::model()->findByPk($aid);
		$this->render('index', array('articleInfo'=>$articleInfo));
	}
}