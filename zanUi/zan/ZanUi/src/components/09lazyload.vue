<template>
	<div class="lazyload">
		<!--图片的懒加载  只需要将 要加载的图片地址写在   v-lazy="图片地址" -->
		<!--<img v-for="img in imageList" v-lazy="img" >-->
			
		<!--背景图片的懒加载   v-lazy:background-image="图片地址"-->
		<div class="img" v-for='img in imageList'  v-lazy:background-image="img">
		</div>
			
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      imageList: [
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/01-IMG_5708.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/09-IMG_0470.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/23-IMG_4600.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/01-IMG_5708.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/09-IMG_0470.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/23-IMG_4600.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/01-IMG_5708.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/09-IMG_0470.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/23-IMG_4600.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/01-IMG_5708.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/09-IMG_0470.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/23-IMG_4600.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/01-IMG_5708.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/09-IMG_0470.JPG',
	        'http://www.houdunwang.com/theme/houdunwang//images/beijing/23-IMG_4600.JPG'
	      ]
	    };
	  }
	}
</script>

<style>
	.lazyload{
		padding: 10px;
		
	}
	.lazyload img{
		width: 100%;
		margin: 10px 0px;
	}
	
	.img{
		width: 100%;
		height: 300px;
		margin: 20px 0px;
	}
</style>