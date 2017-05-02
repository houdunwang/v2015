<?php
	//链接数据数据库
	$pdo=new Pdo('mysql:host=127.0.0.1;dbname=chartjs','root','123456');
	//循环的得到每一天的销售数量
	//11-1    11-7
	//where time=11-1
	// line    lables  data
	for($i=1;$i<=7;$i++){
		//组合labels值
		$labels[]='11-'.$i;
		//组合sql
		$sql="select sum(nums) as nums from sale_list where time='11-".$i."'";
		// 得到结果集
		$res=$pdo->query($sql);
		//得到结果
		$rows=$res->fetchAll(PDO::FETCH_ASSOC);
		// var_dump($rows);
		$data[]=$rows[0]['nums'];
	}
/*	var_dump($lables);
	var_dump($data);*/
	//组合line图表数据结构
	$line=array(
			//x轴显示的数据
			'labels'=>$labels,
			// 具体的数据以及样式
			'datasets'=>array(
					0=>array(
							//填充颜色
							'fillColor'=>'rgba(100,200,100,0.7)',
							'data'=>$data
						)
				)
		);
	//json，将$line转化为json字符串
	$str=json_encode($line);
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
	<div style="width:30%">
		<canvas id="chart" width="400" height="200"></canvas>
	</div>
	<script type="text/javascript">
		$(function(){
			//获取数据，
			var data=<?php echo $str?>;
			//抓取canvas标签
			var chart=$('#chart').get(0).getContext('2d');
			//创建图表对象
			var c=new Chart(chart);
			//绘制图表
			c.Line(data,{
				//设置图表响应式效果
				responsive:true
			});
		})
	</script>
</body>
</html>