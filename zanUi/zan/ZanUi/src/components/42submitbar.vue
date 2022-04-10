<template>
	<div class="submitbar">
		<!--button-text  提交按钮的文本-->
		<!--price  价格（单位是分）-->
		<!--<van-submit-bar
		  :price="3050"
		  button-text="提交订单"
		  @submit="onSubmit"
		/>-->
		<!--禁用状态-->
		<!--disabled  禁用-->
		<!--tip  提示信息-->
		<!--<van-submit-bar
		  disabled
		  :price="3050"
		  button-text="提交订单"
		  tip="您的收货地址不支持同城送, 我们已为您推荐快递"
		  @submit="onSubmit"
		/>-->
		
		<!--loading 加载状态-->
		
		<!--<van-submit-bar
		  loading
		  :price="3050"
		  button-text="提交订单"
		  @submit="onSubmit"
		/>-->
		
		<van-submit-bar
		  :price="3050"
		  button-text="提交订单"
		  @submit="onSubmit"
		  label='总价：'
		>
		  <van-checkbox v-model="checked">全选</van-checkbox>
		  <span slot="tip">
		    您的收货地址不支持同城送, <span>修改地址</span>
		  </span>
		</van-submit-bar>
	</div>
</template>

<script>
	export default{
		data(){
			return{
				checked:true,
			}
		},
		methods:{
			onSubmit (){
				this.$toast('点击提交按钮')
			}
		}
	}
</script>

<style>
</style>