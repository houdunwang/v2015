// 根据设备的高度来设置容器的高度
var h = window.innerHeight;
var box = document.getElementById('box');
box.style.height = h + "px";

// 音乐部分的设置
var m_c = document.getElementById('music_click');
var m_m = document.getElementById("music_mp3");
var c = 0;
// 点击播放和暂停
m_c.onclick=function(){
	if(c==0){
        // 音乐暂停
	    m_m.pause();
        m_c.style.animationPlayState = "paused";
	    c=1;
	}else{
        // 音乐播放
        m_m.play();
        m_c.style.animationPlayState = "running";
        c=0;
	}	
}

var mySwiper = new Swiper ('.swiper-container', {
	// 水平方向滑动     horizontal（竖直方向）
    direction: 'vertical',
    // 环路（循环）
    loop: true, 
    // 分页器
    pagination: '.swiper-pagination',
    // 自动播放
    autoplay:8000,
    // 滑动速度
    speed:1000,
    // 初始化时在第几个屏上
    initialSlide :0,


    onInit: function(swiper){ //Swiper2.x的初始化是onFirstInit
       swiperAnimateCache(swiper); //隐藏动画元素 
       swiperAnimate(swiper); //初始化完成开始动画
    }, 
    onSlideChangeEnd: function(swiper){ 
       swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
    } 

}) 













