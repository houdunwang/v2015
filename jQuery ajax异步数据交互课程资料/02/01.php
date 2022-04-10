<?php

	if($_POST['cid']=='88'){
		$arr = array(
			0=>array(
				'name'=>'张三',
				'age'=>'22',
				'sex'=>'男',
				'address'=>'北京市丰台区大红门1号',
			),
			1=>array(
				'name'=>'李四',
				'age'=>'26',
				'sex'=>'男',
				'address'=>'山东省济南市历下区',
			),
			2=>array(
				'name'=>'王五',
				'age'=>'21',
				'sex'=>'女',
				'address'=>'河北省邢台市一二三镇',
			),
			3=>array(
				'name'=>'赵六',
				'age'=>'26',
				'sex'=>'男',
				'address'=>'天津市静海区12号',
			),
		);
	}
	
	
	echo json_encode($arr);




?>