<template>
	<div class="toast">
		<input type="button" name="" id="" value="点击" @click="onClick" />
	</div>
</template>

<script>
	import { Toast } from 'vant';
	export default{
		data(){
			return{
				 
			}
		},
		methods:{
			onClick(){
//				默认的提示
//				Toast('我是提示文案，建议不超过十五字~');
//				加载中的提示
//				Toast.loading({
////					是否显示背景蒙层
//				  mask: true,
////				  提示的文字
//				  message: '加载中...'
//				});
				
//				提示成功的文案
//				Toast.success('提交成功');
//				提示失败
//				Toast.fail('提交失败');


//				高级用法
				const toast = Toast.loading({
				  duration: 0,       // 持续展示 toast
				  forbidClick: true, // 禁用背景点击
//				  加载图标类型 
				  loadingType: 'spinner',
//				  提示的文字
				  message: '倒计时 3 秒'
				});
				
				let second = 3;
				const timer = setInterval(() => {
				  second--;
				  if (second) {
				    toast.message = `倒计时 ${second} 秒`;
				  } else {
				    clearInterval(timer);
//				   	关闭轻提示
				    Toast.clear();
				  }
				}, 1000);


			}
		}
	}
</script>

<style>
</style>