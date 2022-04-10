<template>
	<div class="addressedit">
		<!--area-list  地址列表-->
		<!--address-info= 要编辑的地址-->
		<!--show-postal 是否显示邮政编码-->
		<!--is-saving 保存按钮的 加载中动画-->
		<van-address-edit
		  :area-list="areaList"
		  :address-info='info'
		  show-postal

		  show-delete
		  show-set-default
		  show-search-result
		  :search-result="searchResult"
		  @save="onSave"
		  @delete="onDelete"
		  @change-detail="onChangeDetail"
		/>
	</div>
</template>

<script>
	const  areaList= {
	  province_list: {
	    110000: '北京市',
	    120000: '天津市',
	    130000:'天涯市'
	  },
	  city_list: {
	    110100: '北京市',
	    110200: '县',
	    120100: '天津市',
	    120200: '县',
	    130100:'海角市'
	  },
	  county_list: {
	    110101: '东城区',
	    110102: '西城区',
	    110105: '朝阳区',
	    110106: '丰台区',
	    120101: '和平区',
	    120102: '河东区',
	    120103: '河西区',
	    120104: '南开区',
	    120105: '河北区',
	    130101: '胡同区'
	
	  }
	}
	
//	收货人信息
	const info={
		id:0,
		name:'张三',
		tel:'12345678912',
		province:'天涯省',
		city:'海角市',
		county:'胡同区',
		address_detail:'东北角',
		area_code:'130101',
		postal_code:'000000',
		is_default:false
	}
	
	export default {
  data() {
    return {
      areaList,
      searchResult: [],
      info:info
    }
  },

  methods: {
    onSave(obj) {
		console.log(obj)
    },
    onDelete() {
      Toast('delete');
    },
    onChangeDetail(val) {
      if (val) {
//    	提示地址
        this.searchResult = [{
          name: '黄龙万科中心111',
          address: '杭州市西湖区'
        }];
      } else {
        this.searchResult = [];
      }
    }
  }
}
</script>

<style>
</style>