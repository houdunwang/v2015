<template>
	<div class="button">
		<!--type 改变按钮类型-->
		
		<div class="one">
			<van-button type="default">默认按钮</van-button>
			<!--给按钮绑定事件-->
			<van-button type="primary" @click='run' >主要按钮</van-button>
			<van-button type="danger">危险按钮</van-button>
		</div>
		
		<!--size改变按钮尺寸-->
		<div class="two">
			<van-button size="large">大号按钮</van-button>
			<van-button size="normal">普通按钮</van-button>
			<van-button size="small">小型按钮</van-button>
			<van-button size="mini">迷你按钮</van-button>
		</div>
		
		<!--disabled 禁用按钮  绑定的点击事件是不好使的-->
		
		<div class="three">
			<van-button disabled type="primary" @click='run' >主要按钮</van-button>
		</div>
		
		<!--loading  加载状态的按钮-->
		<div >
			<van-button loading />
			<van-button loading type="primary" />
		</div>
		
		<!--tag="a" 指定按钮是一个什么标签
		href 跳转地址
		target  在新页面打开地址-->
		<div >
			<van-button tag="a" href="https://www.baidu.com" target="_blank">
			  按钮
			</van-button>
		</div>
		
		<!--bottom-action 底部行动按钮-->
		<div >
			<van-button type="primary" bottom-action>按钮</van-button>
		
			<van-row>
			  <van-col span="12">
			    <van-button bottom-action>按钮</van-button>
			  </van-col>
			  <van-col span="12">
			    <van-button type="primary" bottom-action>按钮</van-button>
			  </van-col>
			</van-row>
		</div>
		
	</div>
</template>

<script>
	
	export default {
	  data() {
	    return {
	    };
	  },
	  methods: {
	    run() {
	      alert('后盾人')
	    }
	  }
	};
</script>

<style>
	div{
		margin-top: 20px;
	}
</style>