<link href="<?php echo Yii::app()->request->baseUrl ?>/assets/index/css/category.css" rel="stylesheet" />
<div id="main">
		<div class='news'>
		<?php foreach($articleInfo as $v): ?>
			<div class='newsList'>
				<div class='newsImage'>
					<a href="<?php echo $this->createUrl('article/index', array('aid'=>$v->aid)) ?>"><img width="" src="<?php echo Yii::app()->request->baseUrl ?>/uploads/<?php echo $v->thumb ?>" /></a>
				</div>
				<div class='newsContent'>
					<h3><a href="<?php echo $this->createUrl('article/index', array('aid'=>$v->aid)) ?>"><?php echo $v->title ?></a></h3>
					<p><?php echo $v->info ?></p>
					<a href="<?php echo $this->createUrl('article/index', array('aid'=>$v->aid)) ?>" class='more'>更多>></a>
				</div>
			</div>
		<?php endforeach ?>
		</div>
		




