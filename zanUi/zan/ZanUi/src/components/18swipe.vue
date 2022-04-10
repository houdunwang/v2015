<template>
	<div class="swipe">
		<!--@change="onChange"  监听事件-->
		<!--:autoplay  控制切换秒数-->
		<!--:loop='false' 控制书否 循环播放 true是循环 默认是true  false不循环-->
		<!--:duration='1000'  控制动画时长-->
		<!--:touchable='false' 禁止手势滑动-->
		<!--:show-indicators 是否显示图片下面的小点-->
		<!--:initial-swipe='1'  控制出事位置-->
		<!--初始写法-->
		<van-swipe :autoplay="3000"  @change="onChange"     >
		  <van-swipe-item v-for='img in images'>
		  		<img :src="img"/>
		  </van-swipe-item>
		</van-swipe>
		
		<!--懒加载-->
		<van-swipe :autoplay="9000"  @change="onChange"     >
		  <van-swipe-item v-for='img in images'>
		  		<img  v-lazy="img"/>
		  </van-swipe-item>
		</van-swipe>
		
		
		<!--vertical  纵向滚动-->
		<van-swipe :autoplay="3000"  @change="onChange"  vertical   >
		  <van-swipe-item v-for='img in images'>
		  		<img :src="img"/>
		  </van-swipe-item>
		</van-swipe>
		
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      images: [
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/01-IMG_5708.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/09-IMG_0470.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/23-IMG_4600.JPG'
	      ]
	    }
	  },
	  methods: {
	    onChange(index) {
	     	console.log(index)
	    }
	  }
	}
</script>

<style>
	img{
		width: 100%;
		height: 210px;
	}
.van-swipe{
	height: 210px;
}
</style>