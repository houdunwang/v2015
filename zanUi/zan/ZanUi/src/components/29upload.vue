<template>
	<div class="upload">
		<!--multiple 多图上传-->
		<!--:after-read  图片上传完成之后执行函数-->
		<!--accept="image/gif, image/jpeg"  接受的文件类型-->
		<!--:max-size 监测文件的尺寸  如果尺寸大于指定的值  会调用@oversize事件-->
		<van-uploader :after-read="onRead" :max-size='102400' @oversize='size' accept="image/gif, image/jpeg" multiple>
		  <van-icon name="photograph" />
		</van-uploader>
		
		
		<img v-for='src in img'  :src="src.content"/>
	</div>
</template>

<script>
	export default {
		data() {
	    return {
	    	img:[]
	    };
	  },
	   methods: {
	    onRead(file) {
	      console.log(file)
	      this.img = file
//			this.img = file.content;
	    },
	    size(){
	    	alert('文件过大')
	    }
	  }
	};
</script>

<style>
	img{
		width:100%;
	}
</style>