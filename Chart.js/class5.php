<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="./Chart.min.js"></script>
</head>
<body>
	<!-- chart.js基于html canvas -->
	<canvas id="chart" width="400" height="200"></canvas>
	<script type="text/javascript">
	window.onload=function(){
		//设置数据结构
		// 按照数据结构，这六种图表分为两大类：（曲线图，柱状图，雷达图） （极地区域图，环形图，饼图）
		var data={
			labels:['周一','周二','周三','周四','周五'],
			datasets:[
				{
					fillColor:"rgba(200,0,100,0.7)",
					data:[10,12,45,65,30]
				},
				{
					fillColor:"rgba(100,100,0,0.7)",
					data:[30,10,35,60,20]
				}
			]
		}
		//抓取canvas标签，创建对象
		var chart=document.getElementById('chart').getContext('2d');
		var c=new Chart(chart);
		//创建柱状图
		// c.Bar(data);
		
		//创建雷达图
		c.Radar(data,{
			animation:false
		});
	}
	</script>
</body>
</html>