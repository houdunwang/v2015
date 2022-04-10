<template>
	
	<div class="collapse">
		<!--name="1" 用老规定当期标签的序号-->
		<!--v-model 让几号折叠面板打开-->
		<!--title 所显示的内容-->
		<!--accordion 设置手风琴效果-->
		<van-collapse v-model="activeNames" accordion>
		   <van-collapse-item name="1">
		    <div slot="title">有赞微商城<van-icon name="edit" /></div>
		    提供多样店铺模板，快速搭建网上商城
		  </van-collapse-item>
		  <van-collapse-item title="有赞零售" name="2">
		    网店吸粉获客、会员分层营销、一机多种收款，告别经营低效和客户流失
		  </van-collapse-item>
		  <van-collapse-item title="有赞美业" name="3">
		    线上拓客，随时预约，贴心顺手的开单收银
		  </van-collapse-item>
		</van-collapse>
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      activeNames: ['2']
	    };
	  }
	};
</script>

<style>
</style>