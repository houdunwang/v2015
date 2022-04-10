Page({

  data:{
    price:100
  },

  inputfoo:function(e){
      console.log(e.detail.value);
      // 将用户最新输入的值设置给price
      this.setData({
        price:e.detail.value
      })
  }
 
})