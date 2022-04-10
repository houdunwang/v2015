<template>
	<div id="Layout">
		<!--span="4"  列宽-->
		<van-row>
		  <van-col class='s1' span="4">span: 4</van-col>
		  <van-col class='s2' span="10">span: 8</van-col>
		  <van-col class='s3' span="10">span: 8</van-col>
		</van-row>
		
		<!--offset='20'  表示偏移-->
		<van-row>
		  <van-col class='s1' span="4" offset='20'>span: 4</van-col>
		</van-row>
		
		<!--gutter="20"  改变列间距 单位是px-->
		<van-row gutter="20">
		  <van-col span="8">
		  	<div class="s1">
		  		第一个
		  	</div>
		  </van-col>
		  <van-col span="8">
		  	<div class="s2">
		  		第二个
		  	</div>
		  </van-col>
		  <van-col span="8">
		  	<div class="s3">
		  		第三个
		  	</div>
		  </van-col>
		</van-row>
	</div>
</template>

<script>
</script>

<style>
	.s1{
		background: red;
	}
	.s2{
		background: blue;
	}
	.s3{
		background: yellow;
	}
</style>