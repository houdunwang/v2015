<template>
	<div class="switchCell">
		<van-cell-group>
			<!--v-model 控制开关的状态-->
			<!--title 左侧的标题-->
			<!--disabled  禁用状态-->
			<!--loading  加载状态-->
			<!--@change  当状态发生改变时 触发的事件-->
		  <van-switch-cell v-model="checked" title="标题"  @change='onChange' />
		</van-cell-group>
		
		
		<van-tree-select
		  :items="items"
		  :main-active-index="mainActiveIndex"
		  :active-id="activeId"
		  @navclick="onNavClick"
		  @itemclick="onItemClick"
		/>
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      checked: true
	    }
	  },
	  methods:{
	  	onChange(){
	  		this.$toast('已经改变')
	  	}
	  }
	}
</script>

<style>
</style>