<template>
	<div class="radio">
		<!--v-model="radio" 当前单选框的值 控制那个单选框选中-->
		<!--name  是唯一标识  也是单选框的value值-->
		<!--<van-radio-group v-model="radio">
		  <van-radio name="1">单选框 1</van-radio>
		  <van-radio name="2">单选框 2</van-radio>
		</van-radio-group>-->
		
		<!--disabled  禁用  当写在van-radio-group 表示将里面所有的单选框全部禁用、-->
		<!--当放在 van-radio 表示禁用某个单独的单选框-->
		<!--<van-radio-group v-model="radio" >
		  <van-radio name="1" disabled>单选框 1</van-radio>
		  <van-radio name="2">单选框 2</van-radio>
		</van-radio-group>-->
		
		<van-radio-group v-model="radio">
		  <van-cell-group>
		    <van-cell title="单选框 1" clickable @click="radio = '1'">
		      <van-radio name="1" />
		    </van-cell>
		    <van-cell title="单选框 2" clickable @click="radio = '2'">
		      <van-radio name="2" />
		    </van-cell>
		  </van-cell-group>
		</van-radio-group>
	
		</div>
</template>

<script>

	export default {
	  data() {
	    return {
	      radio: '2'
	    }
	  }
	};
</script>

<style>
</style>