<template>
	<div id="chckbox">
		<!--v-model="checked  checked值如果为 true 就选中否则就不选中-->
		<!--disabled 禁用状态-->
		<!--label-disabled  禁止点击文字控制-->
		<!--<van-checkbox v-model="checked" >复选框</van-checkbox>-->
		
		
		<!--多选组-->
		<!--:max="2" 最大可选值-->
		<van-checkbox-group v-model="result" :max="2" @change='onChange'>
		  <van-checkbox
		    v-for="(item, index) in list"
		    :key="item"
		    :name="item"
		  >
		    复选框 {{ item }}
		  </van-checkbox>
		</van-checkbox-group>
		
		
		<van-checkbox-group v-model="result">
		  <van-cell-group>
		    <van-cell v-for="item in list" :title="`复选框 ${item}`" :key="item">
		      <van-checkbox :name="item" />
		    </van-cell>
		  </van-cell-group>
		</van-checkbox-group>
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	      checked: false,
	      list: ['a', 'b', 'c'],
     	  result: ['a', 'b']
	    };
	  },
	  methods:{
	  	onChange(index){
//	  		index  是我们选中的表单的值
	  		alert(index)
	  	}
	  }
	};
</script>

<style>
</style>