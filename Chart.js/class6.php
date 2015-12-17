<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="./Chart.min.js"></script>
</head>
<body>
	<!-- 创建canvas标签 -->
	<canvas id="chart" width="400" height="200"></canvas>
	<script type="text/javascript">
		window.onload=function(){
			//设置数据结构
			var data=[
				{
					value:20,
					color:"rgba(2,121,103,0.7)",
					highlight:"rgba(2,121,103,0.4)"
				},
				{
					value:45,
					color:"rgba(146,131,0,0.7)",
					highlight:"rgba(146,131,0,0.4)"
				},
				{
					value:70,
					color:"rgba(143,3,183,0.7)",
					highlight:"rgba(143,3,183,0.4)"
				},
				{
					value:50,
					color:"rgba(158,56,51,0.7)",
					highlight:"rgba(158,56,51,0.4)"
				}
			];
			//抓取标签
			var chart=document.getElementById('chart').getContext('2d');
			//创建chart对象
			var c=new Chart(chart);
			//创建饼图
			// c.Pie(data);
			/*c.Doughnut(data,{
				// 设置环形中间空白的大小
				percentageInnerCutout:10
			});*/

			//创建极地区域图
			c.PolarArea(data);
		}
	</script>
</body>
</html>