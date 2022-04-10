<template>
	<div class="switch">
		<!--v-model="checked"  控制当前开关的状态-->
		<!--disabled 禁用状态-->
		<!--loading 加载状态-->
		<!--<van-switch v-model="checked" loading />-->
		
		<!--size 改变当前按钮的尺寸-->
		<van-switch :value="checked" size="36px" @input="onInput" />
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      checked: true
	    };
	  },
	
	  methods: {
	    onInput(checked) {
	      console.log(checked)
	      this.checked = checked
	    }
	  }
	}; 
</script>

<style>
</style>