<template>
	<div class="coupon">
		<!-- 优惠券单元格 -->
		<van-coupon-cell
		  :coupons="coupons"
		  :chosen-coupon="chosenCoupon"
		  @click="showList = true"
		  title='优惠券'
		/>
		
			<!--coupons 可使用的优惠券列表-->
			<!--disabled-coupons 不可使用的优惠券列表-->
		
		<!-- 优惠券列表 -->
		<van-popup v-model="showList" position="bottom">
		  <van-coupon-list
		    :coupons="coupons"
		    :chosen-coupon="chosenCoupon"
		    :disabled-coupons="disabledCoupons"
		    @change="onChange"
		    @exchange="onExchange"
		    exchange-button-text='按钮'
		    :show-exchange-bar='false'
		  />
		</van-popup>
	</div>
</template>

<script>
	const coupon = {
	  available: 1,
	  discount: 0,
	  denominations: 5000,
	  origin_condition: 0,
	  reason: '',
	  value: 5000,
	  name: '优惠券名称',
	  start_at: 1489104000,
	  end_at: 1514592000
	};
	const scoupon = [{
	  available: 1,
	  discount: 0,
	  denominations: 150,
	  origin_condition: 5000,
	  reason: '',
	  value: 150,
	  name: '优惠券名称1',
	  start_at: 1489104000,
	  end_at: 1514592000
	},
	{
	  available: 1,
	  discount: 20,
	  denominations: 0,
	  origin_condition: 0,
	  reason: '',
	  value: 150,
	  name: '优惠券名称2',
	  start_at: 1489104000,
	  end_at: 1514592000
	}
	,{
	  available: 1,
	  discount: 0,
	  denominations: 150,
	  origin_condition: 0,
	  reason: '',
	  value: 150,
	  name: '优惠券名称3',
	  start_at: 1489104000,
	  end_at: 1514592000
	}
	];
	
	export default {
	  data() {
	    return {
	      chosenCoupon: 0,
	      coupons: [coupon],
	      disabledCoupons: scoupon,
	      showList:false
	    }
	  },
	
	  methods: {
	    onChange(index) {
	      this.showList = false;
	      this.chosenCoupon = index;
	    },
	    onExchange(code) {
	      this.coupons.push(coupon);
	    }
	  }
	}
</script>

<style>
</style>