<template>
	<div class="circle">
		 <!--v-model 从百分之几开始-->
		 <!--rate 变化到百分之几-->
<!--		 speed 动画的运动时间  越小越慢-->
			<!--text改变填充内容-->
			<!--size 表示圆环的直径-->
			<!--color 进度条的颜色-->
			<!--layer-color 轨道的颜色-->
			<!--fill 填充颜色-->
			 <!--:stroke-width 设置进度条的宽度-->
			 <!--:clockwise 运动方向 true为顺时针 false为逆时针-->
		<van-circle
		  v-model="currentRate"
		  :rate="90"
		  :speed="10"
		  :text="text"
		  size='200px'
		  color = 'red'
		  layer-color='yellow'
		  fill='green'
		  :stroke-width="80"
		  :clockwise="false"
		/>
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      currentRate: 10
	    };
	  },
	  computed: {
	    text() {
//	    	console.log(this.currentRate.toFixed(0))
			
	      return '进度'+this.currentRate.toFixed(0) + '%'
	    }
	  }
	};
</script>

<style>
</style>