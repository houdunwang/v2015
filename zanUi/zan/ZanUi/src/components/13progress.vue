<template>
	<div class="progress">
		<!--:percentage="80"  控制进度条的进度-->
		<van-progress :percentage="80" />
		<p>
			置灰
		</p>
		<!--inactive  置灰的属性-->
		<van-progress inactive :percentage="50" />
		<p>自定义样式</p>
		
		 <!--pivot-text 改变显示的字体-->
		 <!--color 改变进度条颜色-->
		<van-progress
		  pivot-text="黑色"
		  color="black"
		  :percentage="25"
		/>
	</div>
</template>

<script>
</script>

<style>
	.progress{
		padding: 20px 0px;
	}
</style>