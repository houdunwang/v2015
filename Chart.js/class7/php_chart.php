<?php 
	//定义一个符合chart需要的数据格式
	$arr=array(
			0=>array(
					'value'=>30,
					'color'=>'rgba(200,100,0,0.7)',
				),
			1=>array(
					'value'=>50,
					'color'=>'rgba(100,200,100,0.7)'
				),
			2=>array(
					'value'=>10,
					'color'=>'rgba(0,100,100,0.7)'
				)
		);

	// 通过json_encode将数组转化为json字符串
	$str=json_encode($arr);
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="./jquery-1.7.2.min.js"></script>	
	<!-- 引入chart.min.js文件 -->
	<script type="text/javascript" src="./Chart.min.js"></script>
</head>
<body>
	<canvas id="chart" width="400" height="200"></canvas>
	<script type="text/javascript">
		$(function(){
			// 获取php输出的变量信息
			var data=<?php echo $str?>;
			//通过jquery抓取对象，需要注意的是要get(0).getContext('2d')
			var chart=$('#chart').get(0).getContext('2d');
			//创建Chart对象
			var c=new Chart(chart);
			//创建饼状图
			c.Pie(data);
		})
	</script>
</body>
</html>