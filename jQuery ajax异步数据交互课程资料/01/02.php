<?php

	if($_POST['stuname']=='张三'){
		$arr = Array(
			'name'=>'张三',
			'sex'=>'男',
			'age'=>'25',
			'tel'=>'18666666666',
		);
	}else{
		$arr = array('没有查询到相关同学');
	}

	
	
	echo json_encode($arr);


?>