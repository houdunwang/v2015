<template>
	<div class="silder">
		<!--v-model="value"  滑块当前的值-->
		<!--<van-slider v-model="value" @change="onChange" />-->
		<p>选择指定范围</p>
		<!--:min="10"  最小值--> 
		<!--:max="90" 最大值-->
		<!--<van-slider v-model="value" :min="10" :max="90" @change="onChange" />-->
		<p>禁用状态</p>
		<!--disabled  禁用-->
		<van-slider disabled v-model="value" :min="10" :max="90"  />
		
		<p>指定步长</p>
		
		<!--:step="10" 控制步长-->
		<!--bar-height="10px" 改变滑块的高度   单位是px-->
		<van-slider v-model="value" :step="10" bar-height="10px" @change="onChange" />
	
	</div>
</template>

<script>
	export default {
  data() {
    return {
      value: 10
    };
  },

  methods: {
    onChange(value) {
      this.$toast('当前值：' + value);
    }
  }
};
</script>

<style>
	.silder{
		padding: 20px 0px;
	}
</style>