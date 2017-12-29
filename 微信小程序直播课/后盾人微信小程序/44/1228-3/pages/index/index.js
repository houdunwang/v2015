Page({
  
  data:{
    yongyong:{
      name:'幸福的勇勇',
      age:'18'
    },
    xianyu: {
      name: '一条咸鱼',
      age: '56'
    }
    
  },

  // 跳转到test页面的方法
  gotest:function(){
    // 跳转
    wx.navigateTo({
      url: '../test/test'
    })
  }


})