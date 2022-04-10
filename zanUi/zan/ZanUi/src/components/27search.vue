<template>
	<div class="search">
		<!--v-model="value" 搜索的内容-->
		<!--placeholder 提示性的语句-->
		<!--background 搜索框的背景颜色-->
		<!--show-action='true'  是否显示取消按钮 false 表示不显示 true表示显示-->
		<!--<van-search background='yellow' show-action='true' placeholder="请输入商品名称" v-model="value" />-->
	
	<!--@search  当点击键盘上的搜索或回车键是会触发这个事件-->
	<!--@cancel当点击取消按钮时出发-->
		<!--<van-search
		    v-model="value"
		    placeholder="请输入商品名称"
		    show-action
		    @search="onSearch"
		    @cancel="onCancel"
		  />-->
		  <!--slot="action"  代表右侧取消的按键-->
		  <van-search
		  v-model="value"
		  show-action
		  @search="onSearch"
		>
		  <div slot="action" @click="onSearch">搜索</div>
		</van-search>
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	    	value:''
	    }
	  },
	  methods:{
	  	onSearch(){
	  		alert('搜索')
	  	},
	  	onCancel(){
	  		alert('取消')
	  	}
	  }
	
	};
</script>

<style>
	*{
		margin: 0px;
		padding: 0px;
	}
</style>