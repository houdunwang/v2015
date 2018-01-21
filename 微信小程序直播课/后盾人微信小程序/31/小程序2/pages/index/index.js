Page({
  // 定义页面数据
  data:{
     click:0//click变量用来记录点击按钮的次数
  },

  // 点击按钮后触发的事件
    tapscreen:function(){
      // console.log('666');
      // this.data.click = this.data.click+1;
      // console.log(this.data.click);
      // 如果要更新数据并且让视图层相关区域重新渲染，就必须用this.setData
      this.setData({
        click: this.data.click+1
      })
    }

})








