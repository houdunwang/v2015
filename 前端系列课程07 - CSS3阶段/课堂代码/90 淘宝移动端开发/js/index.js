//轮播图
var mySwiper = new Swiper ('.swiper-container', {
    direction: 'horizontal',
    loop: true,
    
    // 如果需要分页器
    pagination: {
      el: '.swiper-pagination',
    },
    
})        
//轮播图结束

//淘宝头条
 var mySwiper2 = new Swiper ('.swiper-container2', {
    direction: 'vertical',
    loop: true,
    allowTouchMove:false,
//  自动切换
    autoplay: {
	    delay: 2000,
	    stopOnLastSlide: false,
	    disableOnInteraction: true,
    }
})        
//淘宝头条结束



if (localStorage.getItem('appadsta')==1) {
	$("#appad").hide();
}

//关闭app广告
$("#appad .close").on('touchstart',function(){
	$("#appad").hide();
//	写入本地值
	localStorage.setItem('appadsta','1');
})
//关闭app广告结束


