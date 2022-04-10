<template>
	<div class="tab">
		<!--v-model="active" 控制默认选中的标签-->
		<!--:swipe-threshold='4'  设置标签超过多少个的时候可以滚动-->
		<!--:disabled="index === 2"  禁用相应序号的的选项-->
		<!--@disabled="onClickDisabled"  给禁用选项绑定事件-->
		<!--type="card"  修改样式-->
		<!--@click="onClick"  给选项卡 绑定点击事件-->
		<!--sticky  将选项卡自动吸附在顶部-->
		<!--swipeable  可以滑动内容切换-->
		<van-tabs v-model="active" sticky swipeable   :swipe-threshold='4' @click="onClick" @disabled="onClickDisabled">
		  <van-tab v-for="index in 8" :title="'选项 ' + index"  :disabled="index === 2">
		    <div class="box">
		    	内容 {{ index }}
		    </div>
		  </van-tab>
		</van-tabs>
		
		
		<!--slot="title"  自定义 title里面的内容-->
		<!--<van-tabs v-model="active" sticky   :swipe-threshold='4' @click="onClick" @disabled="onClickDisabled">
		  <van-tab v-for="index in 2"  >
		  	<div slot="title">
		      <van-icon name="more-o" />选项
		    </div>
		    <div class="box">
		    	内容 {{ index }}
		    </div>
		  </van-tab>
		</van-tabs>-->
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      active: 2
	    };
	  },
	    methods: {
	    onClickDisabled(index, title) {
	      console.log(title+'已经被禁用')
	    },
	     onClick(index, title) {
		      this.$toast(title);
		    }
	  }
	}
</script>

<style>
	.tab{
		height: 2000px;
	}
	.box{
		height: 200px;
		background: yellow;
	}
</style>