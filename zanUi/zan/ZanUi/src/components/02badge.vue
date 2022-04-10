<template>
	<div class="badge">
		<!--title="第一个" 显示的文字-->
		<!--info="有信息" 就是我们的徽章-->
		<!--url='http://www.baidu.com'  用来指定跳转地址-->
		<van-badge-group :active-key="activeKey">
		  <van-badge title="第一个" @click="onClick" url='http://www.baidu.com' />
		  <van-badge title="第二个" @click="onClick" info="有信息" />
		  <van-badge title="第三个" @click="onClick" info="99" />
		  <van-badge title="第四个" @click="onClick" info="199" />
		</van-badge-group>
	</div>
</template>

<script>
	
	export default {
	  data() {
	    return {
	      activeKey: 0
	    };
	  },
	  methods: {
	    onClick(key) {
	      this.activeKey = key;
	    }
	  }
	};
</script>

<style>
</style>