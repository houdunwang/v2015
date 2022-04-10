<template>
		<div class="list">
			<!--:offset='10' 当滚动条距离底部的距离 小于10 的时候 就会触发load 事件-->
			<!--loading-text 加载中的提示文案-->
			<!--:immediate-check  是否一进来就检查滚动条高度-->
			<van-list
			  v-model="loading"
			  :finished="finished"
			  @load="onLoad"
			  :offset='10'
			  loading-text='客官请不要着急....'
			  :immediate-check='true'
			>
			  <van-cell v-for="item in list" :key="item" :title="item + ''" />
			</van-list>
		</div>
</template>

<script>
	
	export default {
  data() {
    return {
      list: [],
      loading: false,
      finished: false
    };
  },

  methods: {
    onLoad() {
      setTimeout(() => {
        for (let i = 0; i < 10; i++) {
          this.list.push(this.list.length + 1);
        }
        this.loading = false;

        if (this.list.length >= 40) {
          this.finished = true;
        }
      }, 5000);
    }
  }
}
</script>

<style>
</style>