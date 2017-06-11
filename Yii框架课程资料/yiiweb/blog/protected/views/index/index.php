<link href="<?php echo Yii::app()->request->baseUrl ?>/assets/index/css/index.css" rel="stylesheet" />
	<div id="main">
		<div class='content'>
			<div  class='list'>
				<div class='title'>
					<h2>最新文章.. </h2>
				</div>
				<ul>
				<?php foreach($articleNew as $v): ?>
					<li>
						<div class='post-image'>
							<span>
								<a href="<?php echo $this->createUrl('article/index', array('aid'=>$v->aid)) ?>"><img width="" src="<?php echo Yii::app()->request->baseUrl ?>/uploads/<?php echo $v->thumb ?>" /></a>
							</span>	
						</div>	
						<div class='post-content'>
							<a href="<?php echo $this->createUrl('article/index', array('aid'=>$v->aid)) ?>"><h3><?php echo $v->title ?></h3></a>
							<p><?php echo $v->info ?></p>
						</div>
					</li>
				<?php endforeach ?>
				</ul>
			</div>
			<div  class='list'>
				<div class='title'>
					<h2>热门文章..</h2>
				</div>
				<ul>
				<?php foreach($articleHot as $v): ?>
					<li>
						<div class='post-image'>
							<span>
								<a href="<?php echo $this->createUrl('article/index', array('aid'=>$v->aid)) ?>"><img width="" src="<?php echo Yii::app()->request->baseUrl ?>/uploads/<?php echo $v->thumb ?>" /></a>
							</span>	
						</div>	
						<div class='post-content'>
							<a href="<?php echo $this->createUrl('article/index', array('aid'=>$v->aid)) ?>"><h3><?php echo $v->title ?></h3></a>
							<p><?php echo $v->info ?></p>
						</div>
					</li>
				<?php endforeach ?>
				</ul>
			</div>
		</div>





	