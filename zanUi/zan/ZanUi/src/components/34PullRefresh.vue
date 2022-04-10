<template>
	<div class="PullRefresh">
		 <!--v-model 当前是否在加载中-->
		 <!--@refresh 刷新事件-->
		 <!--pulling-text='下拉...' 下拉时的顶部文案-->
		 <!--loosing-text='松开刷新'  释放过程中顶部的文案-->
		  <!--loading-text='正在加载' 加载中顶部的文案-->
		  <!--animation-duration='1000'  顶部返回时的动画时长-->
		<van-pull-refresh v-model="isLoading" @refresh="onRefresh" pulling-text='下拉...' loosing-text='松开刷新' loading-text='正在加载' animation-duration='1000'>
		  <p  class="p1">刷新次数: {{ count }}</p>
		</van-pull-refresh>
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      count: 0,
	      isLoading: false
	    }
	  },
	
	  methods: {
	    onRefresh() {
	      setTimeout(() => {
	        this.$toast('刷新成功');
	        this.isLoading = false;
	        this.count++;
	      }, 500);
	    }
	  }
	}
</script>

<style>
	.p1{
		height: 300px;
	}
</style>