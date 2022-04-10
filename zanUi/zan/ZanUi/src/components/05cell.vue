<template>
	<div class="cell">
		<van-cell-group>
		  <van-cell title="家电" value="更多" />
		  <van-cell title="单元格" value="内容" label="今天天气真好" />
		</van-cell-group>
		
		<!--只设置value-->
		<van-cell-group>
		  <van-cell value="更多" />
		</van-cell-group>
		
		<!--icon 图标-->
		<van-cell-group>
		  <van-cell title="单元格" icon="certificate" />
		</van-cell-group>
		
		<!--is-link 让单元格右侧显示箭头-->
		<van-cell-group>
		  <van-cell title="单元格" icon='certificate' is-link />
		  <van-cell title="单元格" is-link value="内容" />
		</van-cell-group>
		
		
		<van-cell-group>
		  <van-cell value="内容" icon="shop" is-link>
		  	<!--自定义title里面内容-->
		    <template slot="title">
		      <span class="van-cell-text">单元格</span>
		      <!--徽章-->
		      <van-tag type="danger">标签</van-tag>
		    </template>
		  </van-cell>
		  <van-cell title="单元格" icon="location" is-link />
		  <van-cell title="单元格">
		    <van-icon slot="right-icon" name="like" class="van-cell__right-icon" />
		  </van-cell>
		</van-cell-group>
	</div>
</template>

<script>
</script>

<style>
</style>