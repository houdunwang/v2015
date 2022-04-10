<template>
	<div class="area">
		<!--value='城市的编号'  默认选中 县级城市-->
		<!--:columns-num="2"  省市县显示列数-->
		<van-area :area-list="areaList" @confirm='con'  />
	</div>
</template>

<script>
	const  areaList= {
  province_list: {
    110000: '北京市',
    120000: '天津市'
  },
  city_list: {
    110100: '北京市',
    110200: '县',
    120100: '天津市',
    120200: '县'
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

  }
}
	
	export default{
		data(){
			return{
				areaList:areaList 
			}
		},
		methods:{
//			code 参数
			con(code){
				console.log(code)
			}
		}
	}
</script>

<style>
</style>