<?php

	if($_POST['kw']=='北京'){
		$arr = array('北京天气','北京爱情故事','北京故宫','去北京必吃的小吃');
	}else{
		$arr = array('没有查询到相关数据');
	};
	
	echo json_encode($arr);


?>