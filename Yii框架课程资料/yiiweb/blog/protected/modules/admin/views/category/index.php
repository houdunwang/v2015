<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/assets/admin/css/public.css">
	<title>Document</title>
</head>
<body>
	<?php 
		if(Yii::app()->user->hasFlash('hasArt')){
			echo Yii::app()->user->getFlash('hasArt');
		}
	 ?>
	<table class="table">
		<tr>
			<td class="th" colspan="10">查看栏目</td>
		</tr>
		<tr>
			<td>CID</td>
			<td>栏目名称</td>
			<td>操作</td>
		</tr>

		<?php foreach($categoryInfo as $v): ?>
			<tr>
				<td><?php echo $v->cid ?></td>
				<td><?php echo $v->cname ?></td>
				<td>
					[<a href="<?php echo $this->createUrl('edit', array('cid'=>$v->cid)) ?>">编辑</a>]
					[<a href="<?php echo $this->createUrl('del', array('cid'=>$v->cid)) ?>">删除</a>]
				</td>
			</tr>
		<?php endforeach ?>
	</table>
</body>
</html>