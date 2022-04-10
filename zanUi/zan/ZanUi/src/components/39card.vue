<template>
	<div class="card">
		<!--:centered='true'  内容垂直居中-->
		<!--currency  货币的符号-->
		<!--<van-card
		  title="标题"
		  desc="描述"
		  num="2"
		  price="2.00"
		  :thumb="imageURL"
		  :centered='true'
		/>-->
		
		<!--高级用法-->
		<van-card
		  title="标题"
		  desc="描述"  
		  :num="num"
		  price="2.00"
		  :thumb="imageURL"
		>
		  <div slot="footer">
		    <van-button size="mini" @click = 'zengjia'>增加</van-button>
		    <van-button size="mini" @click = 'jianshao'>减少</van-button>
		  </div>
		</van-card>
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	    	imageURL:'http://bbs.houdunwang.com/data/attachment/album/201709/09/154858an6gxp2cotgytvv6.jpg',
	    	num:0
	    	
	    }
	  },
	  methods: {
	  	zengjia(){
	  		this.num++;
	  	},
	  	jianshao(){
	  		this.num--;
	  		if(this.num<=0){
	  			this.num=0
	  		}
	  	}
	  }
	}
</script>

<style>
</style>