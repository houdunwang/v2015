<template>
	<div class="password">
		<!-- 密码输入框 -->
		<!--:value 密码输入的内容-->
		 <!--@focus 获取焦点事件-->
		<van-password-input
		  :value="value"
		  info="请输入6 位数字的密码 "
		  @focus="showKeyboard = true"
		/>
		
		<!-- 数字键盘 -->
		<van-number-keyboard
		  :show="showKeyboard"
		  @input="onInput"
		  @delete="onDelete"
		  @blur="showKeyboard = false"
		/>
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      value: '1234',
	      showKeyboard: true
	    };
	  },
	
	  methods: {
	    onInput(key) {
	      this.value = (this.value + key).slice(0, 6);
	      console.log(this.value)
	    },
	    onDelete() {
	      this.value = this.value.slice(0, this.value.length - 1);
	    }
	  }
	}
</script>

<style>
</style>