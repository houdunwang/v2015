<template>
	<div class="TreeSelect">
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
	
	const items = [
				  {
				    // 导航名称
				    text: '所有城市',
				    // 该导航下所有的可选项
				    children: [
				      {
				        // 可选项的名称
				        text: '温州',
				        // 可选项的id，高亮的时候是根据id是否和选中的id是否相同进行判断的
				        id: 1002
				      },
				      {
				        // 可选项的名称
				        text: '杭州',
				        // 可选项的id，高亮的时候是根据id是否和选中的id是否相同进行判断的
				        id: 1001
				      }
				    ]
				  },
				  {
				    // 导航名称
				    text: '浙江',
				    // 该导航下所有的可选项
				    children: [
				      {
				        // 可选项的名称
				        text: '杭州',
				        // 可选项的id，高亮的时候是根据id是否和选中的id是否相同进行判断的
				        id: 1003
				      },
				      {
				        // 可选项的名称
				        text: '宁波',
				        // 可选项的id，高亮的时候是根据id是否和选中的id是否相同进行判断的
				        id: 1004
				      },
				      {
				        // 可选项的名称
				        text: '温州',
				        // 可选项的id，高亮的时候是根据id是否和选中的id是否相同进行判断的
				        id: 1005
				      },
				      {
				        // 可选项的名称
				        text: '嘉兴',
				        // 可选项的id，高亮的时候是根据id是否和选中的id是否相同进行判断的
				        id: 1006
				      }
				    ]
				  },
				  {
				    // 导航名称
				    text: '福建',
				    // 该导航下所有的可选项
				    children: [
				      {
				        // 可选项的名称
				        text: '福州',
				        // 可选项的id，高亮的时候是根据id是否和选中的id是否相同进行判断的
				        id: 1007
				      },
				      {
				        // 可选项的名称
				        text: '厦门',
				        // 可选项的id，高亮的时候是根据id是否和选中的id是否相同进行判断的
				        id: 1008
				      },
				      {
				        // 可选项的名称
				        text: '莆田',
				        // 可选项的id，高亮的时候是根据id是否和选中的id是否相同进行判断的
				        id: 1009
				      },
				      {
				        // 可选项的名称
				        text: '三明',
				        // 可选项的id，高亮的时候是根据id是否和选中的id是否相同进行判断的
				        id: 1010
				      }
				    ]
				  }
				]
	export default {
	  data() {
	    return {
	      items: items,
	      // 左侧高亮元素的index
	      mainActiveIndex: 1,
	      // 被选中元素的id
	      activeId: 1004
	    };
	  },
	  methods: {
	    onNavClick(index) {
	      this.mainActiveIndex = index;
	    },
	    onItemClick(data) {
	      this.activeId = data.id;
	    }
	  }
	}
	
</script>

<style>
</style>