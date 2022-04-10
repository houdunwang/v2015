<template>
	<div class="steps">
		<!--:active="active" 当前选中的进度条的位置-->
		<!--<van-steps :active="active">
		  <van-step>买家下单</van-step>
		  <van-step>商家接单</van-step>
		  <van-step>买家提货</van-step>
		  <van-step>交易完成</van-step>
	</van-steps>-->
	
	
	<!--icon 控制 图标-->
	<!--title 标题-->
	<!--description 描述 简介-->
	<!--<van-steps
	  :active="active"
	  icon="gift"
	  title="标题"
	  description="描述信息"
	>
	  <van-step>买家下单</van-step>
	  <van-step>商家接单</van-step>
	  <van-step>买家提货</van-step>
	  <van-step>交易完成</van-step>
	</van-steps>-->
	
	<!--direction="vertical" 改变步骤条的 类型-->
	<!--active-color="#f60  选中状态的颜色-->
	<van-steps direction="vertical" :active="active" active-color="blue">
	  <van-step>
	    <h3>【城市】物流状态1</h3>
	    <p>2016-07-12 12:40</p>
	  </van-step>
	  <van-step>
	    <h3>【城市】物流状态2</h3>
	    <p>2016-07-11 10:00</p>
	  </van-step>
	  <van-step>
	    <h3>快件已发货</h3>
	    <p>2016-07-10 09:30</p>
	  </van-step>
	</van-steps>
	
	
	<input type="button" @click="next" id="" value="下一步" />
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      active: 0
	    };
	  },
	  methods:{
	  	next(){
	  		this.active++;
	  		if(this.active>3){
	  			this.active=3
	  		}
	  	}
	  }
	}
</script>

<style>
</style>