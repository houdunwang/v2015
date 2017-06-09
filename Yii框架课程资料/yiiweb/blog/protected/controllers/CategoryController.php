<?php
/**
 * 栏目管理控制器
 */
class CategoryController extends Controller{
	/**
	 * 默认显示栏目页
	 */
	public function actionIndex($cid){
		$articleInfo = Yii::app()->cache->get('cate');

		if($articleInfo == false){
			$sql = "SELECT thumb,title,info,aid FROM {{article}} WHERE cid=$cid";
			$articleInfo = Article::model()->findAllBySql($sql);
			Yii::app()->cache->set('cate',$articleInfo, 10);
		}
		


		$this->render('index', array('articleInfo'=>$articleInfo));
	}
}