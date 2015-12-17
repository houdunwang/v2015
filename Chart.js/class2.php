<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="./Chart.min.js"></script>
</head>
<body>
	<!-- 图像绘制的容器，就相当于画板 -->
	<canvas id="line" width="400" height="240"></canvas>
	<script type="text/javascript">
		// 获取canvas这个标签的对象,告诉他绘制的是2维图像
		var line=document.getElementById('line').getContext('2d');
		// 创建chart对象
		var lineChart=new Chart(line);
		//绘制图表使用的数据
		var data = {
			labels : ["January","February","March","April","May","June","July"],
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : [65,59,90,81,56,55,40]
				},
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : [28,48,40,19,96,27,100]
				}
			]
		}
		// 调用line方法，画出折线图
		lineChart.Line(data);
	</script>
</body>
</html>