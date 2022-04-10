<template>
	<div class="picker">
		<van-picker :columns="columns" @change="onChange" />
	</div>
</template>

<script>
	const citys = {
	  '浙江': ['杭州', '宁波', '温州', '嘉兴', '湖州'],
	  '福建': ['福州', '厦门', '莆田', '三明', '泉州']
	};

export default {
  data() {
    return {
      columns: [
        {
          values: Object.keys(citys),
//        设置class名
          className: 'column1',
            defaultIndex: 1
        },
        {
          values: citys['福建'],
          className: 'column2',
//        控制默认选中
          defaultIndex: 0
        }
      ]
    };
  },
  methods: {
    onChange(picker, values) {
      picker.setColumnValues(1, citys[values[0]]);
    }
  }
};
</script>

<style>
</style>