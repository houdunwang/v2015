$(function(){
	//动态获取首页slider div的高度
  var width = $(window).width();
  var height = $(window).height();
  var pcimgheight = $('.slider img').height();
  $(".slider").css('width', width);
  $(".slider").css('height', height - 80);
  $(".slider img").css('top', -(pcimgheight - height) / 2);

//首页轮播图js
  var c = 0;
  var d = 0;
  var e = $('.slider ul').children('li').length;
  function lbtrun(){
    c++;
    c = (c>e - 1)?0:c;
     // $('.slider img').stop().eq(c).css("display",'block').siblings('img').stop().css("display",'none');
     $('.slider .tjnews').stop().eq(c).fadeIn().siblings('.tjnews').stop().fadeOut();
     $('.slider ul li').eq(c).css('opacity','1').siblings('li').css('opacity','0.4');
  }
  lbttimer = setInterval(lbtrun,5000);
  //首页手机轮播图js
  // function sjlbtrun(){
  //   d++;
  //   d = (d>e - 1)?0:d;
  //    // $('.sjslider img').stop().eq(c).css("display",'block').siblings('img').stop().css("display",'none');
  //    $('.sjslider .tjnews').stop().eq(c).fadeIn().siblings('.tjnews').stop().fadeOut();
  //    $('.sjslider ul li').eq(d).css('background','white').siblings('li').css('background','#ccc');
  // }
  // sjlbttimer = setInterval(sjlbtrun,5000);

  // 轮播图鼠标移入停止轮播，移除重新轮播
  //移入时左右箭头出现，移出时左右箭头隐藏 
  $(".slider").hover(function() {
    clearInterval(lbttimer);
    $('.slider .zuojiantou').show();
    $('.slider .youJiantou').show();
  }, function() {
    $('.slider .zuojiantou').hide();
    $('.slider .youJiantou').hide();
    lbttimer = setInterval(lbtrun,5000);
  });
  // 点击左箭头
  var jt_s = 1;
  $(".slider .zuojiantou").click(function() {
    if(jt_s==1){
      jt_s = 0;
      setTimeout(function(){
        jt_s = 1;
      },220);
      c--;
      c = (c==-1)?e - 1:c;
      $('.slider .tjnews').eq(c).fadeIn().siblings('.tjnews').stop().fadeOut();
      $('.slider ul li').eq(c).css('opacity','1').siblings('li').css('opacity','0.4');
    }
  });
  //点击右箭头
  $(".slider .youJiantou").click(function() {
    if(jt_s==1){
      jt_s = 0;
      setTimeout(function(){
        jt_s = 1;
      },400);
      c++;
      c = (c>e - 1)?0:c;
      $('.slider .tjnews').eq(c).fadeIn().siblings('.tjnews').stop().fadeOut();
      $('.slider ul li').eq(c).css('opacity','1').siblings('li').css('opacity','0.4');
    }
  });


  //点击li
  $(".slider ul li").click(function(){
    c = $(this).index();
    $('.slider .tjnews').eq(c).fadeIn().siblings('.tjnews').stop().fadeOut();
    $('.slider ul li').eq(c).css('opacity','1').siblings('li').css('opacity','0.4');
  })

})