
	<link href="<?php echo Yii::app()->request->baseUrl ?>/assets/index/css/details.css" rel="stylesheet" />
	<div id="main">
		<div class='details'>
			<h1><?php echo $articleInfo->title ?></h1>
			<div class='info'>
				<div class='base'>
					<em>发表于 <?php echo date('H:i:s', $articleInfo->time) ?></em>, 分类：<strong><?php echo $articleInfo['cate']->cname ?></strong>
				</div>
			</div>
			<div class='content'>
				<?php echo $articleInfo->content ?>
			</div>
		</div>

		