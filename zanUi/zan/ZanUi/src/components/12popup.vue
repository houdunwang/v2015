<template>
	<div class="popup">
		<!--position  控制弹出层的位置 bottom表示底部 -->
		<!--:overlay='false'  是否显示背景蒙层 默认值是true 显示  false  不显示-->
		<van-popup class='pop'  v-model="show" position='right' :overlay='false' >
			
			<div class="box">
				<van-icon  @click = 'close' name="close" />
			</div>
		</van-popup>
		
		<input type="button" @click="pop" name="" id="" value="点击" />
	</div>
	
</template>

<script>
	export default {
	  data() {
	    return {
	      show: false
	    }
	  },
	  methods:{
	  	pop(){
	  		
	  		this.show = true
	  	},
	  	close(){
	  		this.show = false;
	  	}
	  }
	};
</script>

<style>
	.pop{
		width:100% ;
		height: 100%;
		background: yellow;
	}
	.box{
		width: 100%;
		height: 400px;
		background: red;
	}
</style>