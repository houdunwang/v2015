<template>
	<div class="numkey">
		<van-button @touchstart.native.stop="show = true">
		  弹出键盘
		</van-button>
		
		<!--:show用来控制键盘的显示和隐藏-->
		 <!--extra-key 改变左下角键盘的值-->
		 <!--close-button-text 关闭按钮的文字-->
		 <!--@blur  d点击关闭按钮时出发-->
		  <!--@input="onInput" 点击正常的数字按钮时触发-->
		  <!--@delete 点击删除按钮时出发-->
		   <!--@show 键盘完全显示时出发的事件-->
		   <!--@hide 键盘完全收起时出发的事件-->
		<!--<van-number-keyboard
		  :show="show"
		  extra-key="."
		  close-button-text="完成"
		  @blur="onBlur"
		  @input="onInput"
		  @delete="onDelete"
		  @show='onShow'
		/>-->
		
		
		<!--theme  设置键盘风格 default 是默认值-->
		 <!--title='后盾人' 键盘的标题-->
		<van-number-keyboard
		  :show="show"
		  theme="custom"
		  extra-key="."
		  close-button-text="完成"
		  @blur="show = false"
		  @input="onInput"
		  @delete="onDelete"
		  title='后盾人'
		/>
		
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      show: true
	    }
	  },
	
	  methods: {
	    onInput(value) {
	      this.$toast(value);
	    },
	    onDelete() {
	      this.$toast('delete');
	    },
	    onBlur(){
	    	this.show= false
	    	this.$toast('关闭按钮');
	    },
	    onShow(){
	    	alert('键盘显示')
	    }
	  }
	}
</script>

<style>
</style>