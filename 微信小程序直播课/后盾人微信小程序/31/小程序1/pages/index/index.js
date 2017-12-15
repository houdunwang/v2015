// 获得小程序的实例
var app = getApp();
// 修改了全局数据
app.globalData.a = '6666';

Page({//声明页面

  data:{
    hd: '后盾人，人人做后盾',
    // 在页面中，获得小程序的实例后，可以直接获得app.js中定义好的全局数据
    h:app.globalData.a + 'houdunren'
  }
  
})