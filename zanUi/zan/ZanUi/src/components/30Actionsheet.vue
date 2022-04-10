<template>
	<div class="actionsheet">
		
		<input type="button" @click="onShow" id="" value="点击" />
		
		
		<!--v-model="show"  控制显隐-->
		
		<!--js里面的参数-->
		<!--callback 绑定事件-->
		<!--name 名字-->
		<!--subname 副标题-->
		<!--loading 加载状态 true表示正在加载  false 不加载-->
		<!--className  设置一个class名-->
		<!--<van-actionsheet v-model="show" :actions="actions"  />-->
	
	 <!--cancel-text='取消' 取消按钮的文案  按下时会关闭当前-->
	 <!--:overlay='false'  取消遮罩-->
		<van-actionsheet v-model="show" :actions="actions" cancel-text='取消' :overlay='false'  />
	
		<!--<van-actionsheet v-model="show" title="后盾人">
		  <p>php培训</p>
		</van-actionsheet>-->
	
	</div>
</template>

<script>
	export default {
  data() {
    return {
      show: false,
	      actions: [
	        {
	          name: '选项',
	          callback: this.onClick
	        },
	        {
	          name: '选项',
	          subname: '描述信息',
	          className:'hd'
	        },
	        {
	          name: '选项',
	          loading: true
	        }
	      ]
	    };
	  },
	
	  methods: {
	    onClick(item) {
	     	console.log(item)
	    },
	    onShow(){
	    	this.show=true
	    }
	  }
	}
</script>

<style>
</style>