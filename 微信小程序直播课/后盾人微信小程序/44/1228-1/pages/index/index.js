Page({
  
  data:{
    stat:true
  },

  showorhide:function(){
    console.log('触发了');
    // 设置stat变量值
    this.setData({
      stat:!this.data.stat
    })
  }


})