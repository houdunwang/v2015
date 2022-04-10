<template>
	<div class="stepper">
		<p>基础用法</p>
		<!--v-model="value" 只是单纯的计数-->
		<!--:default-value="9"  设置初始的默认值-->
		<!--<van-stepper v-model="value"  :default-value="9" />-->
		
		<p>  禁用状态</p>
		<!--disabled  禁用状态-->
		<!--<van-stepper v-model="value"  :default-value="9" disabled />-->
		
		<p>高级用法</p>
		<!--step="2"  步数-->
		 <!--:min="5"  最小值-->
		 <!--:max="40"  最大值-->
		  <!--integer  只能输入整数-->
		<van-stepper
		  v-model="value"
		  integer
		  :min="5"
		  :max="40"
		  :step="2"
		  :default-value="9"
		/>
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      value: 0
	    }
	  }
	}
</script>

<style>
</style>