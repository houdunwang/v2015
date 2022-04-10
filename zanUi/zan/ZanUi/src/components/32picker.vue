<template>
	<div class="picker">
		<!--:columns 控制内容的显示-->
		<!--@change  当发生改变时触发的事件-->
		<!--:show-toolbar='true' 显示顶部栏-->
		<!--title='后盾人' 顶部栏的标题-->
		<!--:loading='true'  加载状态-->
		<!--:item-height='100'  改变选项高度-->
		<!--:visible-item-count='3'  控制选项显示的个数-->
		<!--@confirm  点击完成时出发的事件-->
		<van-picker :columns="columns" @change="onChange" @confirm='onConfirm'  :show-toolbar='true' title='后盾人' :item-height='100' confirm-button-text='完成' :visible-item-count='3' />
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      columns: ['杭州', '宁波', '温州', '嘉兴', '湖州']
	    };
	  },
	  methods: {
	    onChange(picker, value, index) {
//	    	value  当前的内容
//			index  当前序号
	      this.$toast(`当前值：${value}, 当前索引：${index}`);
	    },
	    onConfirm(value,index){
	    	 this.$toast(`当前值：${value}, 当前索引：${index}`);
	    }
	  }
	};
</script>

<style>
</style>