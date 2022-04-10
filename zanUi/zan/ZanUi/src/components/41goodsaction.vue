<template>
	<div class="goodsaction">
		<van-goods-action>
			<!--icon="home" 图标所显示的样式-->
			<!--text 图标下面的文字-->
		  <van-goods-action-mini-btn icon="home"  info="5" text="首页" @click="onClickMiniBtn" />
		  <van-goods-action-mini-btn icon="chat"  info="5" text="客服" @click="onClickMiniBtn" />
		  <van-goods-action-mini-btn icon="cart" text="购物车" @click="onClickMiniBtn1" />
		  <van-goods-action-big-btn text="加入购物车" @click="onClickBigBtn" />
		  <van-goods-action-big-btn text="立即购买" @click="onClickBigBtn" primary />
		</van-goods-action>
	</div>
</template>

<script>
	export default {
	  methods: {
	    onClickMiniBtn() {
	      this.$toast('点击图标');
	    },
	    onClickMiniBtn1() {
	      this.$toast('点击购物车');
	    },
	    onClickBigBtn() {
	       this.$toast('点击按钮');
	    }
	  }
	}
</script>

<style>
</style>