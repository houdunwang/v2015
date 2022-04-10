<template>
	<div id="dialog">
		<input type="button" id="" @click="onClick" value="点击" />
	
	
	<!--confirm-button-text='完成'  确定按钮的文案-->
	<!--:close-on-click-overlay='true' 点击蒙层让他消失-->
			<van-dialog
		  v-model="show"
		  show-cancel-button
		  :before-close="beforeClose"
		  confirm-button-text='完成'
		  :close-on-click-overlay='true'
		>
		  <van-field
		    v-model="username"
		    label="用户名"
		    placeholder="请输入用户名"
		  />
		  <van-field
		    v-model="password"
		    type="password"
		    label="密码"
		    placeholder="请输入密码"
		  />
		</van-dialog>
	
	</div>
</template>

<script>
	import { Dialog } from 'vant';
	export default{
		data(){
			return{
				 show: false,
			      username: '',
			      password: ''
			}
		},
		methods:{
			onClick(){
//				Dialog.alert({
//				  title: '标题',
//				  message: '弹窗内容'
//				}).then(() => {
////					当关闭的时候执行
////					alert('关闭')
//				  // on close
//				});

//				Dialog.confirm({
//				  title: '标题',
//				  message: '弹窗内容'
//				}).then(() => {
////					点击确定之后执行内容
//					alert('确定')
//				  // on confirm
//				}).catch(() => {
////					点击取消之后执行内容
//					alert('取消')
//				  // on cancel
//				});


				this.show = true
			},
			beforeClose(action, done) {
				console.log(done)
		      if (action === 'confirm') {
//		      	点击确定之后执行的内容
		        setTimeout(done, 1000);
		      } else {
//		      	点击取消之后执行的内容
		        done();
		      }
		    }
		}
	}
</script>

<style>
</style>