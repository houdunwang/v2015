<template>
	<div class="rate">
		<!--v-model="value"  控制初始值-->
		<van-rate v-model="value" />
		
		<p>自定义颜色</p>
		<!--:size 改变的是图标的大小-->
		<!--:count  控制星星的总数量-->
		<!--color  改变选中星星的颜色-->
		<!--void-color  设置没有选中时星星的颜色-->
		<van-rate
		  v-model="value"
		  :size="40"
		  :count="2"
		  color="black"
		  void-color="yellow"
		/>
		
		
		<p>禁用状态</p>
		<!--disabled  禁用-->
		<!--disabled-color='blue'  更改禁用状态时没有选中的星星的颜色-->
		 <van-rate v-model="value" disabled disabled-color='blue' />
	</div>
	
</template>

<script>
	export default {
  data() {
    return {
      value: 0
    };
  }
}
</script>

<style>
	.rate{
		padding: 20px 0px;
	}
</style>