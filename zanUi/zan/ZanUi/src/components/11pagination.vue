<template>
	<div class="pagination">
		 <!--v-model="currentPage"  改变页码所在位置-->
		 <!--:total-items="10"   共有多少条数据-->
		 <!--:items-per-page="5"  每一页所显示的数据-->
		<!--<van-pagination 
		  v-model="currentPage" 
		  :total-items="10" 
		  :items-per-page="5"
		/>-->
		
		 <!--:page-count="12"  共有多少页-->
		  <!--mode="simple  改变分页的样式-->
		<!--<van-pagination 
		  v-model="currentPage" 
		  :page-count="12"
		  mode="simple" 
		/>-->
		
		<!--force-ellipses  多出的分页变省略号-->
		<!--:show-page-size="5"  显示页码的条数-->
		<van-pagination 
		  v-model="currentPage" 
		  :total-items="125" 
		  :show-page-size="5" 
		  force-ellipses
		/>
	</div>  
</template>

<script>
	export default {
	  data() {
	    return  {
	      currentPage:3
	    }
	  }
	}
</script>

<style>
</style>