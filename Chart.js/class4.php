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
			//labels的内容就是x轴显示的内容
			labels : ["一月","二月","March","April","May","June","July"],
			datasets : [
				{
					//填充色
					//rgb分别代表红绿蓝，取值范围为：0-255
					//a透明 取值范围值0-1 0完全透明 1完全不透明
					fillColor : "rgba(220,220,220,0.5)",
					//曲线的边框颜色
					strokeColor : "rgba(220,220,220,1)",
					// 数据点的颜色
					pointColor : "rgba(220,220,220,1)",
					// 点边框的颜色
					pointStrokeColor : "#fff",
					// data中存放的是真正的数据
					data : [65,59,90,81,56,55,40]
				}
			]
		}
		// 调用line方法，画出折线图
		lineChart.Line(data,{
			//设置y轴x轴的边框颜色
			scaleLineColor:'rgba(255,0,0,1)',
			// 设置边框宽度
			scaleLineWidth : 3,
			// 是否显示y轴的刻度，false为不显示，true为显示
			scaleShowLabels : true,
			// <%=value%>是一个整体，不能破坏，可以在前面后面写
			scaleLabel : "<%=value%>px",
			// 背景表格是否显示，false为不显示，true为显示
			scaleShowGridLines : false,
			// 是否要曲线显示，false为折线，true为曲线
			bezierCurve : false,
			// 设置是否动画，false为不动，true为动画
			animation:true,
			onAnimationComplete : function(){
				alert('加载完毕');
			}
		});
	</script>
</body>
</html>