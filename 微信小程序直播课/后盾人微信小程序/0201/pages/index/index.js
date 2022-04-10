Page({

  /**
   * 页面的初始数据
   */
  data: {
    news:[
      {
        aid:1,
        title:'后盾人 人人做后盾！',
        imgUrl:'http://bbs.houdunwang.com/data/attachment/block/23/230bbf54adb6a8f3b1a288430166e56e.jpg'
      },
      {
        aid:2,
        title:'后盾人小程序公开课 !',
        imgUrl:'http://bbs.houdunwang.com/data/attachment/block/4e/4ee985629e4a671fefc6fde396738962.jpg'
      }     
    ]
  },


  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

    var that = this;

    // 发送异步请求
    wx.request({
      url: 'https://lcrwb.com/api/list.php', //仅为示例，并非真实的接口地址
      data: {
        udi: '10',
        y: ''
      },
      header: {
        'content-type': 'application/json' // 默认值
      },
      // 成功接收到返回数据后，会执行success方法
      success: function (res) {
        // 将接收到的数据输出
        console.log(res.data);
        // 将接收到的数据设置给news
        that.setData({
          news:res.data
        })
      }
    })
  },


})