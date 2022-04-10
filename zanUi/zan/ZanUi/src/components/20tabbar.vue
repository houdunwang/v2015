<template>
	<div class="tabbar">
		<!--v-model="active"  控制标签栏 选中的位置-->
		<!--icon  控制显示的图标-->
		<!--dot 控制是否显示小红点-->
		<!--info 提示信息-->
		<!--url='http://www.baidu.com'  控制跳转地址-->
		<!--to='/tab'  和vue里路由跳转是一样的-->
		<!--replace  替换页面  没有历史路径-->
		<van-tabbar v-model="active" @change='onChange'>
		  <van-tabbar-item icon="logistics" to='/tab'>标签</van-tabbar-item>
		  <van-tabbar-item icon="chat" dot url='http://www.baidu.com' replace>标签</van-tabbar-item>
		  <van-tabbar-item icon="records" info="99+">标签</van-tabbar-item>
		  <van-tabbar-item icon="gold-coin" info="20">标签</van-tabbar-item>
		</van-tabbar>
		
		
		
		<!--<template slot="icon" slot-scope="props">
		      <img :src="props.active ? icon.active : icon.normal" />
		   </template>  代表的是  icon  这个属性 -->
		<!--<van-tabbar v-model="active">
		  <van-tabbar-item icon="shop">
		    <span>自定义</span>
		    <template slot="icon" slot-scope="props">
		      <img :src="props.active ? icon.active : icon.normal" />
		    </template>
		  </van-tabbar-item>
		  <van-tabbar-item icon="chat">标签</van-tabbar-item>
		  <van-tabbar-item icon="records">标签</van-tabbar-item>
		</van-tabbar>-->
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      active: 2,
	       icon: {
	        normal: '//img.yzcdn.cn/1.png',
	        active: '//img.yzcdn.cn/2.png'
	      }
	    }
	  },
	  methods:{
	  	onChange(active){
	  		alert(active)
	  	}
	  }

	}
</script>

<style>
</style>