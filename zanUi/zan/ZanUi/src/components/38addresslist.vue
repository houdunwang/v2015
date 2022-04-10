<template>
	<div class="addresslist">
		 <!--v-model 选中默认的地址-->
		 <!--:list  地址列表-->
		  <!--@add  新增地址的事件-->
		  <!--@edit  修改地址的事件-->
		  <!--@select  切换选中的地址时触发-->
		  <!--add-button-text='添加地址'  改变底部按钮的值-->
		<van-address-list
		  v-model="chosenAddressId"
		  :list="list"
		  @add="onAdd"
		  @edit="onEdit"
		  @select='onselect'
		  add-button-text='添加地址'
		/>
	</div>
</template>

<script>
	export default {
  data() {
    return {
      chosenAddressId: '2',
      list: [
        {
          id: '1',
          name: '张三',
          tel: '13000000000',
          address: '浙江省杭州市西湖区文三路 138 号东方通信大厦 7 楼 501 室'
        },
        {
          id: '2',
          name: '李四',
          tel: '1310000000',
          address: '浙江省杭州市拱墅区莫干山路 50 号'
        }
      ]
    }
  },

  methods: {
    onAdd() {
      this.$toast('新增收货地址');
    },
    onEdit(item, index) {
      this.$toast('编辑收货地址:' + index);
    },
    onselect(){
    	alert('点击')
    }
  }
}
</script>

<style>
</style>