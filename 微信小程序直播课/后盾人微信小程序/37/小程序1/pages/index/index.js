// pages/index/index.js
Page({

  data: {
    hd: [
      { name: '老张', id: 0 },
      { name: '隔壁老王', id: 1 },
      { name: '老孙', id: 2 },
      { name: '老刘', id: 3 },
    ],
    hd2: [1, 2]
  },

  // 用来增加一条数据的方法
  addneighbor: function () {
    // console.log('触发了');
    // 定义要追加的数据
    var newdata = { name: '老马', id: this.data.hd.length };
    // 组合新数据
    var newhd = [newdata].concat(this.data.hd);
    // 设置新hd
    this.setData({
      hd: newhd
    })

  },

  // 增加数组的方法
  addnumber: function () {
    var newhd2 = [Math.random()].concat(this.data.hd2);
    this.setData({
      hd2:newhd2
    })
  }


})