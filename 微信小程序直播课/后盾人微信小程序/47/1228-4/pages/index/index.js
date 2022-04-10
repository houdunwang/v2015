Page({
  
  data:{
    starttime:0,
    difftime:0
  },

  // 按下的时候触发的方法
  start:function(e){
    console.log('按下了');
    this.setData({
      starttime: e.timeStamp
    })

  },

  // 抬起的时候触发的方法
  end: function (e) {
    console.log('抬起了');
    // 计算用户按的时间
    var d = e.timeStamp - this.data.starttime;
    console.log(d);
    this.setData({
      difftime:d
    })

  }

  


})