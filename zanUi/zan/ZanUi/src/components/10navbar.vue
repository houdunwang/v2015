<template>
	<div class="navbar">
		
		<!--title 标题-->
		<!--left-text="返回"  左侧文本-->
		<!--right-text="按钮"  右侧的文本-->
		<!--left-arrow  是否显示左侧箭头-->
		<!--@click-left  给左侧添加点击事件-->
		<!--@click-right 给右侧添加点击事件-->
		<!--slot  可以自定义  标题  左侧区域的内容  右侧区域的内容-->
		<!--fixed  让导航看固定在顶部-->
		<!--z-index  和定位属性调整层级是一样的-->
		<van-nav-bar
		  title="标题"
		  left-text="返回"
		  right-text="按钮"
		  left-arrow
		  @click-left="onClickLeft"
		  @click-right="onClickRight"
		  z-index=2 
		/>
		
		<!--高级用法-->
		<van-nav-bar title="标题" fixed left-text="返回" left-arrow  >
		  <van-icon name="like" slot="right" />
		</van-nav-bar>
		
		<div class="box">
			
		</div>
	</div>
</template>

<script>
	export default {
	  methods: {
	    onClickLeft() {
	      alert('返回')
	    },
	    onClickRight() {
	      alert('按钮')
	    }
	  }
	}
</script>

<style>
	.box{
		height: 6000px;
		background: red;
	}
</style>